<?php
trait IntroPageModelTrait {
    public function getPicIntro($idpagefe, $isocountry){
        $this->query("SELECT tautan, url_gbr FROM pic_intro WHERE id_hlm = :hlm AND iso_country = :iso AND id_posisi > 0 AND id_posisi < 6 ORDER BY id_posisi");
        $this->bind(':hlm', $idpagefe);
        $this->bind(':iso', $isocountry);
        return $this->resultSet();
    }
    public function insertPicIntro($param, $sql_str = "INSERT INTO pic_intro"){
        return $this->basicQueryInsert($param, $sql_str);
    }
    public function deletePicIntro($param = NULL, $sql_str = "DELETE FROM pic_intro"){
        return $this->basicQueryDelete($param, $sql_str);
    }
}
?>