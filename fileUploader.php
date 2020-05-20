<?php
class  FileUploader{
    private static $target_directory = "/uploads";
    private static $size_limit = 5000;
    private $uploadOk = false;
    private $file_original_name;
    private $file_type;
    private $file_size;
    private $final_file_name;

    public function setOriginalName(){
        $this->file_original_name = $name;
    }

    public function getOriginalName(){
        $this->file_original_name;
    }

    public function setFileType($type){
        $this->file_type = $type;
    }

    public function getFileType($type){
        $this->file_type;
    }

    public function setFileSize(){
        $this->file_size = $size;
    }

    public function getFileSize(){
        $this->file_size;
    }

    public function setFinalFileName($final_file_name){
        $this->final_file_name = $final_name;
    }

    public function getFinalFileName($final_file_name){
        $this->final_file_name;
    }

    public function uploadFile(){
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $this->uploadOk = true;
        }
        $this->target_file = $this->target_directory . basename($_FILES["fileToUpload"]["name"]);

        $this->fileAlreadyExists($this->target_directory);
        $this->fileSizeIsCorrect();
        $this->fileTypeIsCorrect();

        if ($this->uploadOk == false) {

        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $this->target_file)) {
                echo "Image uploaded <br>";
            } else {
                echo "Upload failed<br>";
            }
        }
    }
    public function fileAlreadyExists(){
        $target_file = $target_directory . basename($_FILES["fileToUpload"]["name"]);
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $this->uploadOk = false;
        }
    }
    public function saveFilePathto(){}
    public function moveFile(){}
    public function fileTypeIsCorrect(){
        $imageFileType = strtolower(pathinfo($this->target_file, PATHINFO_EXTENSION));

                if(($imageFileType != "jpg") && ($imageFileType != "png") && ($imageFileType != "jpeg")
                    && ($imageFileType != "gif") ) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $this->uploadOk = false;
                }
    }
    public function fileSizeIsCorrect(){
        if ($_FILES["fileToUpload"]["size"] > $this->size_limit) {
            echo "Sorry, your file is too large.";
            $this->uploadOk = false;
        }
    }
    public function fileWasSelected(){}
}