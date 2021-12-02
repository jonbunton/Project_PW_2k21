<?php
    session_start();
    
    // $form_data = array(); //Pass back the data to `mainAJAX.php`
    // $errors = array(); //To store errors
    // if (empty($_POST['key'])) { //Name cannot be empty
    //     $errors['nilai1'] = 'isi nilai1';
    // } 


    // if (!empty($errors)) { //If errors in validation
    //     $form_data['success'] = false;
    //     $form_data['errors']  = $errors;
    // }
    // else { //If not, process the form, and return true on success
    //     //$form_data['success'] = true;
    //     //$form_data['posted'] = 'Data Was Posted Successfully';
    // 	$proses = $_SESSION["cart"][$_POST["key"]][1];
    // 	$form_data['success'] = true;
    // 	$form_data['posted'] = $proses;
    // }


    // //Return the data back to form.php
    // echo json_encode($form_data);
?> 
<script>
    $(document).ajaxComplete(function() {
        $('#my-div label').text('my text');
    });
</script>