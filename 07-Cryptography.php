<?php
    //Hashing: Convert a large text into smaller unique text.

        //md5: MD5, which stands for "Message Digest Algorithm 5," is a widely used cryptographic hash function. It takes an input (often referred to as a message) and produces a fixed-size, 128-bit (16-byte) hash value, typically represented as a 32-character hexadecimal number. MD5 is designed to be a one-way function, meaning it should be computationally infeasible to reverse the process and obtain the original input from the hash value. fast but not so much secured, can crack easily. There are many hashing algorithm like that- sha1, hash etc.
        echo md5("Well Well !"); 
        echo sha1("lll");
        print_r(hash_algos()); //all hashing algorithm
        echo hash("md5", "Nothing there!");

        //Salting: Adding extra secret word with password text, then hashing. Then, cracking will be not easy. Make Custom Encryption.
        $salt = "Th@lT7";
        $password = "secret password";
        $hash = md5($password.$salt);
        echo $hash;

        //Secure Hashing: Someone can change our main secret message before hashing. So, we need secure hashing- ex. MAC(Message Authentication Code), HMAC. Like- we are adding our password with the message.
        $message = "Secret Message";
        $pass = "Secret";
        echo hash_hmac("whirlpool", $message, $pass); //there are many algorithms like whrilpool

        //Timing Attack Prevent: string comparison using 'hash_equals()'

        //crypt() function and blowfish salt algorithm to make hash
        $message = "Well";
        $blowfish_salt = "$2y$10$". bin2hex(random_bytes(11)); //openssl_random_pseudo_bytes()
        echo crypt($message, $blowfish_salt);

        //Built in Password Hashing
        $hash = password_hash($pass, PASSWORD_BCRYPT, ['cost'=>10]);
        $userInput = "password";
        echo password_verify($userInput, $hash);
        //We can't decrypt from hash. so, we need encryption.

        //Encryption: Symmetric Encryption(Encrypt and Decrypt with same key), Asymmetric Encryption(public key private key)
        //Symmetric using open ssl
        print_r(openssl_get_cipher_methods());

        $iv_length = openssl_cipher_iv_length('aes-128-cbc');
        $iv = openssl_random_pseudo_bytes($iv_length);
        $message2 = "Message";
        $pass2 = "ta";
        // $encryptedMessage = openssal_encrypt($message2, 'aes-128-cbc', $pass2, 0, $iv);
        //openssl_decrypt()

        //Asymmetric Encryption: openssl, phpseclib

        //Encoding and Decoding: base64_encode, base64_decode

?>