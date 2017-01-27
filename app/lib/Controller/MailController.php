<?php

namespace MailForce\Controller;

use Symfony\Component\HttpFoundation\Response;

class MailController {

    /**
     * Sends an email to the recepient
     *
     * @param  string    $email    The recepient's email address 
     */
    public function sendMail($email) {

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            try {

                // create the SMTP transport using provided credentials
                $transport = \Swift_SmtpTransport::newInstance( getenv('SMTP_HOST'), getenv('SMTP_PORT'), getenv('SMTP_ENCRYPTION'));
                $transport->setUsername( getenv('SMTP_USERNAME') );
                $transport->setPassword( getenv('SMTP_PASSWORD') );

                // create the mailer using the smtp transport
			    $mailer = \Swift_Mailer::newInstance($transport);

                // create the message
                $from = getenv('SMTP_SENDER') ? getenv('SMTP_SENDER') : 'info@mailforce.local' ;
                $subject = "You've got mail";
                $body = 'Hi, ' . "\r\n \r\n" . 
                    'May the Force be with you!!' . "\r\n \r\n" .
                    'Regards,';

                $message = \Swift_Message::newInstance()
                    ->setFrom($from)
                    ->setTo($email)
                    ->setSubject($subject)
                    ->setBody($body);

                // send the message
                $response = $mailer->send($message);

                if ($response) {

                    $payload = array(
                        'status' => 'success',
                        'message' => 'The email was sent successfuly'
                    );
                    return new Response(json_encode($payload), 200, array('content-type' => 'application/json'));

                } else {

                    $payload = array(
                        'status' => 'error',
                        'message' => 'An error occured and the email was not sent'
                    );
                    return new Response(json_encode($payload), 200, array('content-type' => 'application/json'));

                }

            } catch(Exception $e) {

                $payload = array(
                    'status' => 'error',
                    'message' => 'Something happened and we are unable to send the email. Please check your credentials.'
                );
                return new Response(json_encode($payload), 200, array('content-type' => 'application/json'));

            } catch(\Swift_TransportException $e) {

                $payload = array(
                    'status' => 'error',
                    'message' => 'Something happened and we are unable to connect to the mail server. Please check your credentials.'
                );
                return new Response(json_encode($payload), 200, array('content-type' => 'application/json'));

            } catch(\Swift_RfcComplianceException $e) {

                $payload = array(
                    'status' => 'error',
                    'message' => 'Something happened and we are unable to send the email. The SMTP_SENDER setting is not a valid email address.'
                );
                return new Response(json_encode($payload), 200, array('content-type' => 'application/json'));

            }

        } else {
            
            $payload = array(
                'status' => 'error',
                'message' => 'The email address you provided is not valid.'
            );
            return new Response(json_encode($payload), 200, array('content-type' => 'application/json'));

        }

    }

    /**
     * Sends a notification to sender SMTP_EMAIL
     *
     * @param  string    $email    The applicants email address 
     */
    public function notify($email) {

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            try {

                // create the SMTP transport using provided credentials
                $transport = \Swift_SmtpTransport::newInstance( getenv('SMTP_HOST'), getenv('SMTP_PORT'), getenv('SMTP_ENCRYPTION'));
                $transport->setUsername( getenv('SMTP_USERNAME') );
                $transport->setPassword( getenv('SMTP_PASSWORD') );

                // create the mailer using the smtp transport
			    $mailer = \Swift_Mailer::newInstance($transport);

                // create the message
                $to = getenv('SMTP_EMAIL');
                $from = getenv('SMTP_SENDER') ? getenv('SMTP_SENDER') : 'info@mailforce.local' ;
                $subject = "Job Application [Notification]";
                $body = 'Hi, ' . "\r\n \r\n" . 
                    "$email, just started the job application, better follow up with them." . "\r\n \r\n" .
                    'Regards,';
                    
                $message = \Swift_Message::newInstance()
                    ->setFrom($from)
                    ->setTo($to)
                    ->setSubject($subject)
                    ->setBody($body);

                // send the message
                $response = $mailer->send($message);

                if ($response) {

                    $payload = array(
                        'status' => 'success',
                        'message' => 'The email was sent successfuly'
                    );
                    return new Response(json_encode($payload), 200, array('content-type' => 'application/json'));

                } else {

                    $payload = array(
                        'status' => 'error',
                        'message' => 'An error occured and the email was not sent'
                    );
                    return new Response(json_encode($payload), 200, array('content-type' => 'application/json'));

                }

            } catch(Exception $e) {

                $payload = array(
                    'status' => 'error',
                    'message' => 'Something happened and we are unable to send the email. Please check your credentials.'
                );
                return new Response(json_encode($payload), 200, array('content-type' => 'application/json'));

            } catch(\Swift_TransportException $e) {

                $payload = array(
                    'status' => 'error',
                    'message' => 'Something happened and we are unable to connect to the mail server. Please check your credentials.'
                );
                return new Response(json_encode($payload), 200, array('content-type' => 'application/json'));

            } catch(\Swift_RfcComplianceException $e) {

                $payload = array(
                    'status' => 'error',
                    'message' => 'Something happened and we are unable to send the email. The SMTP_SENDER setting is not a valid email address.'
                );
                return new Response(json_encode($payload), 200, array('content-type' => 'application/json'));

            }

        } else {
            
            $payload = array(
                'status' => 'error',
                'message' => 'The email address you provided is not valid.'
            );
            return new Response(json_encode($payload), 200, array('content-type' => 'application/json'));

        }

    }
        
}