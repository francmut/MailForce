# MailForce

> A demo implementation of an app for sending emails from client-side javascript (Backend)

Features rate-limited requests to ``` /mailto/{email} ``` and ``` /notify/{email} ``` routes

#### Usage
Send a Get / POST request to ```/notify/{email} ``` to send a notification to a preset email address

Send a GET / POST request to ```/mailto/{email} ``` to send a predefined email to the address.

#### Specific Usage
Send notification of a job application;
```javascript 
<script>
jQuery(document).ready(function($) {
    // sends a notification to a preset email a
    window.getStep3 = function(email) {
        $.ajax({
            type: "POST",
            url: '/notify/'+email,
            dataType: 'json',
            success: function(json) {
                if (json.error) {
                    // handle error
                } else {
                    // handle success
                    // e.g. send an acknowledgement to applicant
                    getStep4(email);
                }
            }
        });
    }
    
    // sends a canned response to the applicant
    window.getStep4 = function(email) {
        $.ajax({
            type: "POST",
            url: '/email/'+email,
            dataType: 'json',
            success: function(json) {
                if (json.error) {
                    // handle error
                } else {
                    // handle success
                }
            }
        });
    }
    
});
</script>
```

### Sample responses
Success message
```{"status":"success","message":"The email was sent successfuly"}```

Error message
```{"status":"error","message":"Something happened and we are unable to connect to the mail server. Please check your credentials."}```