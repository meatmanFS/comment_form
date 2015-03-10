<?php

class commentClass
{
    public function db_connect()
    {
        $db = new mysqli("localhost","root","");
        if ($db->connect_errno) exit ("Не удается подключится к MySQL".$db->connect_error);
        $db->select_db("comment");
        return $db;
    }
    public function get_all_comment() 
    {
        $return = "";
        $db = $this->db_connect();
        $result = $db->query("SELECT * FROM comments ORDER BY id DESC;");
        if ($result)
        {
            foreach ($result as $myrow)
            {
                $return .= '<div class="panel panel-primary comments">
                            <div class="panel-heading">
                                <div class="row" >
                                        <div class="col-md-1">#'.$myrow['id'].'</div>
                                </div>
                                <div class="row">
                                        <div class="col-md-3">'.$myrow['date'].'</div>
                                </div>
                                <div class="row">
                                        <div class="col-md-8">'.$myrow['FIO'].' '.$myrow['email'].'</div>
                                </div>
                            </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-8">'.$myrow['comment'].'</div>
                                    </div>';
                if (($myrow['attached_file'] != '0') && ($myrow['attached_file'] != ""))
                {
                    $return .= '    <div class="row">
                                        <div class="col-md-8">';
                                            $att_files = json_decode($myrow['attached_file']);
                                            foreach ($att_files as $a_files)
                                            {
                                                preg_match("/~(.*)/", $a_files,$a_files_res);
                                                $return .=  '<a href="uploads/'.$a_files.'">'.$a_files_res[1].'</a> ';
                                            }
                    $return .= '    </div>
                                    </div>';
                }
                $return .=     '    
                                </div>
                        </div>';
            }
        }
        echo $return;
        return;
    }
    public function validate($arr)
    {
        foreach ($arr as $item=>$val)
        {
            $arr[$item]=(trim(htmlspecialchars(stripslashes($val))));
        }
        foreach ($arr as $item=>$val)
        {
            switch ($item)
            {
                case "email":$arr["valid"][]=array("$item"=>(preg_match("/^.+@.+[.].{2,}$/i", $val))?"valid":"not_valid");break;
                case "login":$arr["valid"][]=array("$item"=>(preg_match("/^[A-z0-9]{3,}$/", $val))?"valid":"not_valid");break;
                case "password":$arr["valid"][]=array("$item"=>(preg_match("/^[A-z0-9]{6,16}$/i", $val))?"valid":"not_valid");break;
                case "phone":$arr["valid"][]=array("$item"=>(preg_match("/^[0-9]{10}$/i", $val))?"valid":"not_valid");break;
                case "name":$arr["valid"][]=array("$item"=>(preg_match("/^[A-zА-я .]{3,}$/i", $val))?"valid":"not_valid");break;
                case "text":$arr["valid"][]=array("$item"=>(preg_match("/[\w]{3,}/i", $val))?"valid":"not_valid");break;
                case "birth_day":$arr["valid"][]=array("$item"=>(preg_match("/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/i", $val))?"valid":"not_valid");break;
            }
        }
        return $arr;
    }
    public function post_comment($email,$FIO,$phone,$comment) 
    {
        $respond = array();
        $attached_file = array();
        $db = $this->db_connect();
        $date = date('d-m-Y');
        $time = date('H-i-s');
        $validate = $this->validate(array("email"=>$email,"name"=>$FIO,"phone"=>$phone,"text"=>$comment));
        foreach($_FILES as $file)
        {
            $path = "c:\\xampp\\htdocs\\comment_form\\uploads\\".$date."_".$time."~".$file["name"]; 
            if (file_exists($file["tmp_name"]))
            {
                if(move_uploaded_file($file["tmp_name"], $path))
                {
                    $respond[] = Array("respond"=>"Файл ".$file["name"]." успешно загружен!");
                    $attached_file[] = $date."_".$time."~".$file["name"];
                }
                else
                {
                    $respond[] = Array("respond"=>"Не удалось загрузить файл ".$file["name"]."!");
                }
            }
            else
            {
                $respond[] = Array("respond"=>"Не удалось загрузить файл ".$file["name"]."!");
            }
        }
        if ($attached_file)
        {
            $json_attached_file = json_encode($attached_file);
        }
        else
        {
            $json_attached_file = "";
        }
        $valid = true;
        foreach ($validate['valid'] as $valid_in)
        {
            foreach ($valid_in as $item=>$val )
            {
                if ($val!="valid")
                {
                     $respond[] = Array("respond"=>"Введите валидный $item!");
                     $valid = false;
                }

            }
        }
        if ($valid)
        {
            $res = $db->query("INSERT INTO comments (`date`,`email`, `FIO`, `phone`, `comment`, `attached_file`) VALUES ('$date','$email', '$FIO', '$phone', '$comment', '$json_attached_file');");
            if ($res)
            {
                $respond[] = Array("respond"=>"Коментарий отправлен!");
                $SERVER_NAME = $_SERVER['SERVER_NAME'];
                mail($email, "Вы успешно оставили отзыв на $SERVER_NAME", "Вы оствили отщыв на сайте $SERVER_NAME/comment_form/!\n.$comment", 
                    "From: skylineflash@rambler.ru \r\n" 
                   ."X-Mailer: PHP/" . phpversion() ); 
            }
            else
            {
                $respond[] = Array("respond"=>"Не удалось отправить комментарий!");
            }    
        }
            
        echo json_encode($respond);
    }
}
