<?php

namespace rafaelglikis\autogp\Testers;

use rafaelglikis\autogp\Databases\TesterDatabase;
use rafaelglikis\autogp\Helpers\TextHelper;
use rafaelglikis\autogp\Datatypes\Mail;

use rafaelglikis\autogp\Mailers\Mailer;

class Tester
{
    private $testerName;
    private $dbFilename = 'tests';

    public function __construct(string $testerName)
    {
        $this->testerName = $testerName;
    }

    public function test(string $result, $notifications = true)
    {
        $database = new TesterDatabase($this->dbFilename);
        $test = $database->checkResults($this->getTesterName(), $result);
        if ($test)
        {
            print "[+] Test " . $this->getTesterName() . " OK \n";
        }
        else
        {
            print "[-] Test " . $this->getTesterName() . " FAILED \n";

            if($notifications)
            {
                $mail = new Mail();

                $expectedResults = $database->getResults($this->getTesterName());
                $diff = TextHelper::simpleDiff($expectedResults, $result);

                $subject = "Test " . $this->getTesterName() . " FAILED \n";
                $message = '<html><body>';
                $message .= '<h1>' . 'Test ' . $this->getTesterName() . ' FAILED' . '</h1>';
                $message .= '<h2>Expected Results</h2>';
                $message .= $expectedResults;
                $message .= '<h2>Test Results</h2>';
                $message .= $result;
                $message .= '<h2>Differences</h2>';
                $message .= '<p>' . $diff . '</p>';
                $message .= '</body></html>';

                $mail_conf = include("mail_conf.php");
                $mail->setReceversMail($mail_conf["sender_email"]);
                $mail->setSendersMail($mail_conf["receiver_email"]);
                $mail->setSubject($subject);
                $mail->setMessage($message);

                Mailer::sendHtmlMail($mail);
            }

        }
    }

    public function initializeTester($result)
    {
        $database = new TesterDatabase($this->dbFilename);
        $database->updateRecord($this->getTesterName(), $result);
        print "[+] Tester $this->testerName initialized \n";
    }

    /***************************************************************
     *                      SETTERS - GETTERS
     ***************************************************************/

    public function getTesterName(): string
    {
        return $this->testerName;
    }

    public function setTesterName(string $testerName)
    {
        $this->testerName = $testerName;
    }
}