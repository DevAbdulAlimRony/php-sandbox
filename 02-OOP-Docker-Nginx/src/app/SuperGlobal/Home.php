<?php
namespace App\SuperGlobal;

class Home{
    public function index(){
        $_SESSION['count'] = ($_SESSION['count'] ?? 0) + 1; // each time we visit this route, count will increase. Output When First Visit: array(1) {["count"] => int(1)}

        setcookie(
            'UserName',
            'bdul Alim',
            time() + 10, // 10 seconds
            '/',
            '',
            false,
            false
        ); // Name, Value, Expiry Time, In which directoy the cookie will be valid, which domain or subdomain should this cookie be available on, only on secure https or not, http only(only be accessed on http protocol, cannot be accessed by client side call like javascript)
        
        // return 'Home';

        // File Upload
        // If we dont set enctype, $_FILES superglobal will be an empty array
        // We can also take multiple file type input here, if submit it will be in $_FILES array and then we can loop over that super global
        // We can also upload array of file like in the receipt name , multiple file. just name it receipt[]
        return <<<FORM
                <form action="/upload" method="post" enctype="multipart/form-data">
                <input type="file" name="receipt" />
                <button type="submit">Upload</button>
               FORM;
    }

    public function upload(){
        var_dump($_FILES); // reciept array with name (file name), type (mime type), tmp_name (tmp name with where will upload diectory), error, size (in bytes) key
        // error key's val can be: UPLOAD_ERR_OK = 0, UPLOAD_ERR_INI_SIZE = 1, UPLOAD_ERR_FORM_SIZE = 2, UPLOAD_ERR_PARTIAL = 3, UPLOAD_ERR_NO_FILE = 4, UPLOAD_ERR_NO_TMP_DIR = 5, UPLOAD_ERR_CANT_WRITE = 7, UPLOAD_ERR_EXTENSEION = 8
        var_dump(pathinfo($_FILES['receipt']['tmp_name'])); // directory => /tmp, basename => php..., filename => php...
        // When we uplaod, it will be uploaded by default in server's tmp directory, this can be changed from php.ini configuration file
        // We can upload it in cloud like s3 directory or somewhere in local directory. Now, we will move file from tmp to our local directory storage:

        $filePath = STORAGE_PATH . '/' . $_FILES['receipt']['name'];
        move_uploaded_file($_FILES['receipt']['name'], $filePath);

        // Some php.ini directory related to file uploads:
        // file_uploads: 1, we can set it 0
        // upload_tmp_dir: null. we can change this to another directory. the directory must be writable, if not, fallback will be tmp directory
        // upload_max_filesize: '2M'. We can set it, and also must have proper server side validation
        // max_file_uploads: 20. How many files can be uploaded per request, if exceed, it will stop processing file
        // max_input_time: "-1". Sets the maximum time script is allowed to receive input in seconds
    }
}