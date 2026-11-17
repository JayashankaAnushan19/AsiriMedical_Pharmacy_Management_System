-- bcrypt/argon hashes need more than 45 characters
ALTER TABLE `tb_adminuser` MODIFY `user_Password` VARCHAR(255) DEFAULT NULL;
