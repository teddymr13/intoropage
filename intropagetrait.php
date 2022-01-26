<?php
trait IntroPageTrait {
    protected function introPage(){
        if($this->registry->template->login_check){
            $className = strtolower(get_class($this));
            switch($className){
                case 'marketplace' :
                    $page_id = '2|1';
                    break;
                case 'store' :
                    $page_id = '3|3';
                    break;
                case 'hotel' :
                    $page_id = '4|3';
                    break;
                case 'dining' :
                    $page_id = '5|2';
                    break;
                case 'beauty' :
                    $page_id = '6|4';
                    break;
                case 'trade' :
                    $page_id = '7|3';
                    break;
                case 'voucher' :
                    $page_id = '8|3';
                    break;
                case 'newsfeed' :
                    $page_id = '9|2';
                    break;
                case 'system' :
                    $page_id = '15|2';
                    break;
                case 'specialoffers' :
                    $page_id = '16|2';
                    break;
                default :
                    $page_id = NULL;
                    break;
            }
            if($className=='system'){
                $page_title = 'Home Page - System';
                $main_url = 'system/home-page';
                $edit_url = 'system/edit-homepage';
            }
            else{
                $page_title = 'Intro Page - ' . ucfirst($className);
                $main_url = $className.'/intro-page';
                $edit_url = $className.'/edit-intropage';
            }
            if(!empty($page_id) && UserHelper::checkUserAccess($page_id)) {
                $args = array(
                    'url_id' => FILTER_VALIDATE_INT,
                    'orderby' =>array('filter' => FILTER_VALIDATE_INT, 'options' => array('min_range' => 1, 'max_range' => 5))
                );
                $get = filter_input_array(INPUT_GET, $args);

                if (empty($get['url_id'])) $get['url_id'] = 1;
                if (empty($get['orderby'])) $get['orderby'] = 1;
                $get['order'] = 'ASC';
                if (isset($_GET['order']) && $_GET['order'] === 'DESC') $get['order'] = 'DESC';

                $viewmodel = new CountryModel;
                $data_count = $viewmodel->getCountry(array("service_exist"=>1));
                $totalrow = count($data_count);
                if($totalrow > 0) $totalhlm = intval(ceil ($totalrow / LIST_ITEM_LIMIT));
                else $totalhlm = 1;
                if($get['url_id'] > $totalhlm) header('Location: ' . ROOT_PATH . $main_url . '/');

                $param = array();
                $param['service_exist'] = 1;
                switch ($get['orderby']){
                    case 2: $param['order_by'] = array('iso'=>$get['order']); break;
                    default: $param['order_by'] = array('nicename'=>$get['order']); break;
                }
                $limitervalue = array();
                if ($totalrow > LIST_ITEM_LIMIT){
                    $offset = ($get['url_id'] - 1) * LIST_ITEM_LIMIT;
                    $limitervalue["count"] = LIST_ITEM_LIMIT;
                    if (!empty($offset)) $limitervalue["offset"] = $offset;
                }
                if(!empty($limitervalue)) $param['limit'] = $limitervalue;

                $this->registry->template->data_list = $viewmodel->getCountry($param);
                $this->registry->template->main_url = $main_url;
                $this->registry->template->edit_url = $edit_url;
                $this->registry->template->hlm = $get['url_id'];
                $this->registry->template->totalrow = $totalrow;
                $this->registry->template->totalhlm = $totalhlm;

                if(!($get['orderby'] == 1 && $get['order'] == 'ASC')) {
                    $this->registry->template->orderby = $get['orderby'];
                    $this->registry->template->order = strtolower($get['order']);
                }

                $explode_page_title = explode("-", $page_title);
                $this->registry->template->page_title = $page_title;
                $this->registry->template->header_title = trim($explode_page_title[0]);
                $this->registry->template->page_id = $page_id;

                $breadcrumb = array();
                $breadcrumb[0]['str'] = trim($explode_page_title[1]);
                if($className!='system') $breadcrumb[0]['href'] = $className . "/";
                $breadcrumb[1]['str'] = trim($explode_page_title[0]);
                $breadcrumb[1]['active'] = true;
                $this->registry->template->breadcrumb = $breadcrumb;

                $this->registry->imageCSP .= " https://lipis.github.io";
                $this->returnView(true, "includes/list-intro-page.php");
            }
            else Redirect::home();
        }
        else Redirect::signin();
    }

    private function insertPicIntro($data, $pageidfe, $isocountry){
        $viewmodel = new $this->registry->classModelName(NULL, 'd');
        $viewmodel->deletePicIntro(array('id_hlm'=>$pageidfe, 'iso_country'=>$isocountry));
        $viewmodel = new $this->registry->classModelName(NULL, 'i');
        return ($viewmodel->insertPicIntro(array('tautan'=>$data['link_1'], 'url_gbr'=>$data['thumbnail_1'], 'id_posisi'=>1, 'id_hlm'=>$pageidfe, 'iso_country'=>$isocountry)) && $viewmodel->insertPicIntro(array('tautan'=>$data['link_2'], 'url_gbr'=>$data['thumbnail_2'], 'id_posisi'=>2, 'id_hlm'=>$pageidfe, 'iso_country'=>$isocountry)) && $viewmodel->insertPicIntro(array('tautan'=>$data['link_3'], 'url_gbr'=>$data['thumbnail_3'], 'id_posisi'=>3, 'id_hlm'=>$pageidfe, 'iso_country'=>$isocountry)) && $viewmodel->insertPicIntro(array('tautan'=>$data['link_4'], 'url_gbr'=>$data['thumbnail_4'], 'id_posisi'=>4, 'id_hlm'=>$pageidfe, 'iso_country'=>$isocountry)));
    }
    private function editIntroPageGeneral(){
        if($this->registry->template->login_check){
            $className = strtolower(get_class($this));
            switch($className){
                case 'marketplace' :
                    $page_id = '2|1';
                    $dbpageid = 2;
                    break;
                case 'store' :
                    $page_id = '3|3';
                    $dbpageid = 3;
                    break;
                case 'hotel' :
                    $page_id = '4|3';
                    $dbpageid = 6;
                    break;
                case 'dining' :
                    $page_id = '5|2';
                    $dbpageid = 5;
                    break;
                case 'beauty' :
                    $page_id = '6|4';
                    $dbpageid = 9;
                    break;
                case 'trade' :
                    $page_id = '7|3';
                    $dbpageid = 4;
                    break;
                default :
                    $page_id = NULL;
                    break;
            }
            if(!empty($page_id) && UserHelper::checkUserAccess($page_id)) {
                $page_title = "Edit | Intro Page - " . ucfirst($className);
                $parent_url = $className.'/intro-page/';

                $url_id = NULL;
                if(isset($_GET['url_id'])) $url_id = intval(filter_var($_GET['url_id'], FILTER_VALIDATE_INT));

                if(!empty($url_id)) {
                    $db_str = MainHelper::getDbStr($className);
                    $countrmodel = new CountryModel;
                    $data_country = $countrmodel->getCountry(array('id'=>$url_id));
                    $viewmodel = new $this->registry->classModelName;
                    $data_edit = $viewmodel->getPicIntro($dbpageid, $data_country[0]['iso']);
                    $data_edit_main_pic = $viewmodel->getMainPic($db_str, $url_id);
                    if($data_edit && is_array($data_edit) && count($data_edit) == 4 && is_array($data_edit_main_pic)) {
                        if (isset($_POST) && !empty($_POST)) {
                            $args = array(
                                'hid_id' => FILTER_VALIDATE_INT,
                                'thumbnail_1' => array('filter' => FILTER_VALIDATE_URL, 'flags' => FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED),
                                'thumbnail_2' => array('filter' => FILTER_VALIDATE_URL, 'flags' => FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED),
                                'thumbnail_3' => array('filter' => FILTER_VALIDATE_URL, 'flags' => FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED),
                                'thumbnail_4' => array('filter' => FILTER_VALIDATE_URL, 'flags' => FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED),
                                'link_1' => array('filter' => FILTER_VALIDATE_URL, 'flags' => FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED),
                                'link_2' => array('filter' => FILTER_VALIDATE_URL, 'flags' => FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED),
                                'link_3' => array('filter' => FILTER_VALIDATE_URL, 'flags' => FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED),
                                'link_4' => array('filter' => FILTER_VALIDATE_URL, 'flags' => FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED)
                            );
                            $post = filter_input_array(INPUT_POST, $args);
                            if(!empty($post['hid_id']) && !empty($post['thumbnail_1']) && !empty($post['thumbnail_2']) && !empty($post['thumbnail_3']) && !empty($post['thumbnail_4'])) {
                                if($post['hid_id'] == $url_id) {
                                    if(empty($post['link_1'])) $post['link_1'] = '';
                                    if(empty($post['link_2'])) $post['link_2'] = '';
                                    if(empty($post['link_3'])) $post['link_3'] = '';
                                    if(empty($post['link_4'])) $post['link_4'] = '';

                                    $update_thumbnail = $this->insertPicIntro($post, $dbpageid, $data_country[0]['iso']);
                                    $insert_main_slider = $this->insertMainSlider($db_str, $url_id, $_POST['picture'], $_POST['video_or_link'], $_POST['order'], true);

                                    if ($update_thumbnail)$data_edit = $viewmodel->getPicIntro($dbpageid, $data_country[0]['iso']);
                                    if ($insert_main_slider)$data_edit_main_pic = $viewmodel->getMainPic($db_str, $url_id);

                                    if ($update_thumbnail && $insert_main_slider) Messages::setMsg('Successfully update intro page.', 'success', 'Success!');
                                    else Messages::setMsg('Failed to update intro page.', 'danger', 'Error!');
                                }
                                else Messages::setMsg('Invalid ID.', 'danger', 'Error!');
                            }
                            else Messages::setMsg('Incomplete Input Data.', 'danger', 'Error!');
                        }

                        $this->registry->template->data_edit_main_pic = $data_edit_main_pic;
                        $data_edit['id'] = $url_id;
                        $this->registry->template->data_edit = $data_edit;

                        $this->registry->template->page_title = $page_title;
                        $this->registry->template->header_title = "Edit Intro Page";
                        $this->registry->template->page_id = $page_id;
                        $this->registry->template->cancelUrl = $parent_url;

                        $breadcrumb = array();
                        $breadcrumb[0]['str'] = ucfirst($className);
                        if($className == 'beauty') $breadcrumb[0]['str'] = "Beauty &amp; Wellness";
                        $breadcrumb[0]['href'] = $className . '/';
                        $breadcrumb[1]['str'] = "Intro Page";
                        $breadcrumb[1]['href'] = $parent_url;
                        $breadcrumb[2]['str'] = "Edit";
                        $breadcrumb[2]['active'] = true;
                        $this->registry->template->breadcrumb = $breadcrumb;

                        $jsSrc = array();
                        $jsSrc[0]['type'] = "js";
                        $jsSrc[0]['src'] = 'assets/js/bundles/slider-main.js';
                        $jsSrc[1]['type'] = "js";
                        $jsSrc[1]['src'] = 'assets/js/bundles/form-edit-intropage.js';
                        $this->registry->template->jsSrc = $jsSrc;

                        $this->registry->imageCSP .= " https://i.ytimg.com";

                        $this->returnView(true, 'includes/form-edit-intropage.php');
                    }
                    else header('Location: ' . ROOT_PATH . $parent_url);
                }
                else header('Location: ' . ROOT_PATH . $parent_url);
            }
            else Redirect::home();
        }
        else Redirect::signin();
    }
}
?>