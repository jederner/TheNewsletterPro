<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends CI_Controller {

    public function view($page = "home") {

        if (!file_exists(APPPATH . '/views/articles/' . $page . '.php')) {
            show_404();
        }

        $data['siteTitle'] = "The NewsletterPro";
        $data['title'] = "Articles - " . ucfirst($page); // Capitalize the first letter
        $data['assets'] = asset_url();

        $this->load->model('Articles_model');
        $data["article_types"] = $this->Articles_model->getArticleTypes();
        $data['articles'] = $this->Articles_model->getArticlesArray();
        $data["demographics"] = $this->Articles_model->getList("Demographics");

        $this->load->view('templates/header', $data);
        $this->load->view('articles/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function assignToClient($id, $articleid = null, $edition = null) {
        if (!is_numeric($id)) {
            show_404();
        }

        if (is_numeric($articleid)) {
            $this->load->model('Articles_model');
            $this->Articles_model->assignArticle($id, $articleid, $edition);

            $_SESSION["DisplayMessage"] = "Article assigned successfully.";
            redirect("Articles/AssignToClient/$articleid");
        } else {
            $data['siteTitle'] = "The NewsletterPro";
            $data['title'] = "Articles - Assign to Client"; // Capitalize the first letter
            $data['assets'] = asset_url();

            $this->load->model('Articles_model');
            $this->load->model('Clients_model');

            $data['details'] = $this->Articles_model->getArticleDetailsArray($id);
            $data['clients'] = $this->Articles_model->getAvailableClients($id);
            $data['article_id'] = $id;

            $data['assignDate'] = $this->Articles_model->getAssignArticleDate();


            $this->load->view('templates/header', $data);
            $this->load->view('articles/assignToClient.php', $data);
            $this->load->view('templates/footer', $data);
        }
    }

    public function details($id) {

        if (!empty($id)) {

            $data['siteTitle'] = "The NewsletterPro";
            $data['title'] = "Articles - Details"; // Capitalize the first letter
            $data['assets'] = asset_url();

            $this->load->model('Articles_model');

            $data["details"] = $this->Articles_model->getArticleDetailsArray($id);
            $data["article_types"] = $this->Articles_model->getArticleTypes();
            $data["demographics"] = $this->Articles_model->getList("Demographics");
            $data["usage"] = $this->Articles_model->getUsageByArticleId($id);
            $data["usage_count"] = count($data["usage"]);
            $data["loadDataTables"] = true;

            if ($_SESSION["UserRole"] == "admin") {
                $this->load->view('templates/header', $data);
                $this->load->view('articles/details.php', $data);
            } else {
                $this->load->model('List_model');
                $curDemographics = $data["details"][0]["article_demographic"];
                $data["demographicLabels"] = "";
                if (!empty($curDemographics)) {
                    $data["demographicLabels"] = $this->List_model->getLabelsByStringList($curDemographics);
                }
                $curArticleLabels = $data["details"][0]["article_category"];
                $data["articleLabels"] = "";
                if (!empty($curArticleLabels)) {
                    $data["articleLabels"] = $this->List_model->getLabelsByStringList($curArticleLabels);
                }

                $data["noHeader"] = true;
                $this->load->view('templates/header', $data);
                $this->load->view('articles/details-team.php', $data);
            }

            $this->load->view('templates/footer', $data);
        } else {
            show_404();
        }
    }

    public function extractData($submittedDoc) {
        $returnContent = array();
        $tags = array("Headline", "Date Created", "Article Type", "Keywords", "Word Count", "Demographics", "Description");
        include_once("application/libraries/DocxConversion.php");
        $docObj = new DocxConversion($submittedDoc);
        $docText = $docObj->convertToText();
        $content = explode("\n", $docText);
        foreach ($content as $line) {
            $curArray = explode("*", $line);
            if (count($curArray) > 1) {
                for ($i = 1; $i <= count($curArray) + 1; $i++) {
                    if (in_array($curArray[0], $tags)) {
                        $indexName = str_replace(" ", "", $curArray[0]);
                        $indexName = preg_replace('/\h+/', ' ', $indexName);
                        $indexValue = preg_replace('/\h+/', ' ', $curArray[1]);
                        $indexValue = str_replace("\r", "", $indexValue);
                        $indexValue = ltrim($indexValue, " ");
                        $returnContent[$indexName] = $indexValue;
                    }
                }
            }
        }
        //print_r($returnContent);
        return $returnContent;
    }

    public function update() {

        $id = $_POST["id"];
        $article_name = $_POST["article_name"];
        $article_attachment_sm = $_FILES["article_attachment_sm"];
        $article_attachment_md = $_FILES["article_attachment_md"];
        $article_attachment_lg = $_FILES["article_attachment_lg"];
        $article_category = implode(",", $_POST["article_category"]);
        $article_description = $_POST["article_description"];
        $article_wordcount_sm = $_POST["article_wordcount_sm"];
        $article_wordcount_md = $_POST["article_wordcount_md"];
        $article_wordcount_lg = $_POST["article_wordcount_lg"];
        $article_image_sm = $_FILES["article_image_sm"];
        $article_image_md = $_FILES["article_image_md"];
        $article_image_lg = $_FILES["article_image_lg"];
        $article_keywords = $_POST["article_keywords"];
        $article_demographic = implode(",", $_POST["article_demographic"]);
        $article_created = $_POST["article_created"];

        if (!empty($article_attachment_sm["tmp_name"])) {

            $newID = rand();

            $errors = array();
            $file_name = $article_attachment_sm['name'];
            $file_size = $article_attachment_sm['size'];
            $file_tmp = $article_attachment_sm['tmp_name'];
            $file_type = $article_attachment_sm['type'];
            $cleanMe = explode('.', $file_name);
            $file_ext = strtolower(end($cleanMe));

            $extensions = array("doc", "docx", "txt", "pdf", "zip");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Extension not allowed";
            }

            if ($file_size > 10000000) {
                $errors[] = 'File size must be less than 2 MB';
            }

            if (empty($errors) == true) {
                $newName = $newID . "_" . $file_name;
                move_uploaded_file($file_tmp, "./uploads/$newName");

                $data = array(
                    'article_attachment_sm' => "uploads/" . $newName
                );

                $retrieveThis = $this->extractData("uploads/$newName");
                //print_r($retrieveThis);
                //exit;
                $article_name = $retrieveThis["Headline"];
                $article_created = $retrieveThis["DateCreated"];
                $article_wordcount_sm = $retrieveThis["WordCount"];
                $article_description = $retrieveThis["Description"];
                $article_keywords = $retrieveThis["Keywords"];

                $this->db->where('id', $id);
                $this->db->update('articles', $data);
            } else {
                echo "<p>There were some errors in your upload:</p>";
                print_r($errors);
            }
        }

        if (!empty($article_attachment_md["tmp_name"])) {

            $newID = rand();

            $errors = array();
            $file_name = $article_attachment_md['name'];
            $file_size = $article_attachment_md['size'];
            $file_tmp = $article_attachment_md['tmp_name'];
            $file_type = $article_attachment_md['type'];
            $cleanMe = explode('.', $file_name);
            $file_ext = strtolower(end($cleanMe));

            $extensions = array("doc", "docx", "txt", "pdf", "zip");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Extension not allowed";
            }

            if ($file_size > 10000000) {
                $errors[] = 'File size must be less than 2 MB';
            }

            if (empty($errors) == true) {
                $newName = $newID . "_" . $file_name;
                move_uploaded_file($file_tmp, "./uploads/$newName");

                $data = array(
                    'article_attachment_md' => "uploads/" . $newName
                );

                $retrieveThis = $this->extractData("uploads/$newName");
                $article_name = $retrieveThis["Headline"];
                $article_created = $retrieveThis["DateCreated"];
                $article_wordcount_md = $retrieveThis["WordCount"];
                $article_description = $retrieveThis["Description"];
                $article_keywords = $retrieveThis["Keywords"];

                $this->db->where('id', $id);
                $this->db->update('articles', $data);
            } else {
                echo "<p>There were some errors in your upload:</p>";
                print_r($errors);
            }
        }

        if (!empty($article_attachment_lg["tmp_name"])) {

            $newID = rand();

            $errors = array();
            $file_name = $article_attachment_lg['name'];
            $file_size = $article_attachment_lg['size'];
            $file_tmp = $article_attachment_lg['tmp_name'];
            $file_type = $article_attachment_lg['type'];
            $cleanMe = explode('.', $file_name);
            $file_ext = strtolower(end($cleanMe));

            $extensions = array("doc", "docx", "txt", "pdf", "zip");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Extension not allowed";
            }

            if ($file_size > 10000000) {
                $errors[] = 'File size must be less than 2 MB';
            }

            if (empty($errors) == true) {
                $newName = $newID . "_" . $file_name;
                move_uploaded_file($file_tmp, "./uploads/$newName");

                $data = array(
                    'article_attachment_lg' => "uploads/" . $newName
                );

                $retrieveThis = $this->extractData("uploads/$newName");
                $article_name = $retrieveThis["Headline"];
                $article_created = $retrieveThis["DateCreated"];
                $article_wordcount_lg = $retrieveThis["WordCount"];
                $article_description = $retrieveThis["Description"];
                $article_keywords = $retrieveThis["Keywords"];

                $this->db->where('id', $id);
                $this->db->update('articles', $data);
            } else {
                echo "<p>There were some errors in your upload:</p>";
                print_r($errors);
            }
        }

        if (!empty($article_created)) {
            $article_created = date("Y-m-d", strtotime($article_created));
        }

        if (!empty($article_image_sm["tmp_name"])) {
            $newID = rand();

            $errors = array();
            $file_name = $article_image_sm['name'];
            $file_size = $article_image_sm['size'];
            $file_tmp = $article_image_sm['tmp_name'];
            $file_type = $article_image_sm['type'];
            $meFirst = explode('.', $file_name);
            $file_ext = strtolower(end($meFirst));

            $extensions = array("jpg", "jpeg", "gif", "bmp", "png");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Extension not allowed";
            }

            if ($file_size > 10000000) {
                $errors[] = 'File size must be less than 2 MB';
            }

            if (empty($errors) == true) {
                $newName = $newID . "_" . $file_name;
                move_uploaded_file($file_tmp, "./uploads/$newName");

                $data = array(
                    'article_image_sm' => "uploads/" . $newName
                );

                $this->db->where('id', $id);
                $this->db->update('articles', $data);
            } else {
                echo "<p>There were some errors in your upload:</p>";
                print_r($errors);
            }
        }

        if (!empty($article_image_md["tmp_name"])) {

            $newID = rand();

            $errors = array();
            $file_name = $article_image_md['name'];
            $file_size = $article_image_md['size'];
            $file_tmp = $article_image_md['tmp_name'];
            $file_type = $article_image_md['type'];
            $meFirst = explode('.', $file_name);
            $file_ext = strtolower(end($meFirst));

            $extensions = array("jpg", "jpeg", "gif", "bmp", "png");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Extension not allowed";
            }

            if ($file_size > 10000000) {
                $errors[] = 'File size must be less than 2 MB';
            }

            if (empty($errors) == true) {
                $newName = $newID . "_" . $file_name;
                move_uploaded_file($file_tmp, "./uploads/$newName");

                $data = array(
                    'article_image_md' => "uploads/" . $newName
                );

                $this->db->where('id', $id);
                $this->db->update('articles', $data);
            } else {
                echo "<p>There were some errors in your upload:</p>";
                print_r($errors);
            }
        }

        if (!empty($article_image_lg["tmp_name"])) {

            $newID = rand();

            $errors = array();
            $file_name = $article_image_lg['name'];
            $file_size = $article_image_lg['size'];
            $file_tmp = $article_image_lg['tmp_name'];
            $file_type = $article_image_lg['type'];
            $meFirst = explode('.', $file_name);
            $file_ext = strtolower(end($meFirst));

            $extensions = array("jpg", "jpeg", "gif", "bmp", "png");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Extension not allowed";
            }

            if ($file_size > 10000000) {
                $errors[] = 'File size must be less than 2 MB';
            }

            if (empty($errors) == true) {
                $newName = $newID . "_" . $file_name;
                move_uploaded_file($file_tmp, "./uploads/$newName");

                $data = array(
                    'article_image_lg' => "uploads/" . $newName
                );

                $this->db->where('id', $id);
                $this->db->update('articles', $data);
            } else {
                echo "<p>There were some errors in your upload:</p>";
                print_r($errors);
            }
        }

        if (empty($article_created)) {
            $article_created = null;
        }


        $data = array(
            'article_name' => $article_name,
            'article_category' => $article_category,
            'article_description' => $article_description,
            'article_wordcount_sm' => $article_wordcount_sm,
            'article_wordcount_md' => $article_wordcount_md,
            'article_wordcount_lg' => $article_wordcount_lg,
            'article_keywords' => $article_keywords,
            'article_demographic' => $article_demographic,
            'article_created' => $article_created
        );

        $this->db->where('id', $id);
        $this->db->update('articles', $data);

        $_SESSION["DisplayMessage"] = "Record updated successfully.";

        redirect("articles/details/$id");
    }

    public function delete($id) {
        if ($_SESSION["UserRole"] == "admin") {
            if (is_numeric($id)) {
                $this->db->where('id', $id);
                $this->db->delete('articles');

                $this->db->where('article_id');
                $this->db->delete('assigned_articles');

                $whereData = array(
                    'module_id' => $id,
                    'module' => "articles"
                );
                $this->db->where($whereData);
                $this->db->delete('attachments');

                $whereData = array(
                    'module_id' => $id,
                    'module' => "articles_image"
                );
                $this->db->where($whereData);
                $this->db->delete('attachments');

                $_SESSION["DisplayMessage"] = "Article deleted successfully.";
            }
        }
        redirect("articles/view");
    }

    public function add() {

        $article_name = null; //$_POST["article_name"];
        $article_attachment_sm = $_FILES["article_attachment_sm"];
        $article_attachment_md = $_FILES["article_attachment_md"];
        $article_attachment_lg = $_FILES["article_attachment_lg"];
        $article_image_sm = $_FILES["article_image_sm"];
        $article_image_md = $_FILES["article_image_md"];
        $article_image_lg = $_FILES["article_image_lg"];
        $article_category = $_POST["article_category"];
        if (!empty($article_category)) {
            $article_category = implode(",", $article_category);
        }
        $article_description = null; //$_POST["article_description"];
        $article_wordcount_sm = null; //$_POST["article_wordcount_sm"];
        $article_wordcount_md = null; //$_POST["article_wordcount_md"];
        $article_wordcount_lg = null; //$_POST["article_wordcount_lg"];
        $article_keywords = null; //$_POST["article_keywords"];
        $article_demographic = $_POST["article_demographic"];
        if (!empty($article_demographic)) {
            $article_demographic = implode(",", $article_demographic);
        }
        $article_uploaded = date('Y-m-d');
        $article_created = null; //$_POST["article_created"];

        $modID = null;

        if (!empty($article_attachment_sm["tmp_name"])) {

            $newID = rand();

            $errors = array();
            $file_name = $article_attachment_sm['name'];
            $file_size = $article_attachment_sm['size'];
            $file_tmp = $article_attachment_sm['tmp_name'];
            $file_type = $article_attachment_sm['type'];
            $cleanMe = explode('.', $file_name);
            $file_ext = strtolower(end($cleanMe));

            $extensions = array("doc", "docx", "txt", "pdf", "zip");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Extension not allowed: $file_ext";
            }

            if ($file_size > 10000000) {
                $errors[] = 'File size must be less than 2 MB';
            }

            if (empty($errors) == true) {
                $newName = $newID . "_" . $file_name;
                move_uploaded_file($file_tmp, "./uploads/$newName");
                $article_attachment_sm = "uploads/$newName";
                $retrieveThis = $this->extractData("uploads/$newName");
                //print_r($retrieveThis);
                //exit;
                $article_name = $retrieveThis["Headline"];
                $article_created = $retrieveThis["DateCreated"];
                $article_wordcount_sm = $retrieveThis["WordCount"];
                $article_description = $retrieveThis["Description"];
                $article_keywords = $retrieveThis["Keywords"];
            } else {
                echo "<p>There were some errors in your upload:</p>";
                print_r($errors);
            }
        } else {
            $article_attachment_sm = null;
        }

        if (!empty($article_attachment_md["tmp_name"])) {

            //$newID = rand();

            $errors = array();
            $file_name = $article_attachment_md['name'];
            $file_size = $article_attachment_md['size'];
            $file_tmp = $article_attachment_md['tmp_name'];
            $file_type = $article_attachment_md['type'];
            $cleanMe = explode('.', $file_name);
            $file_ext = strtolower(end($cleanMe));

            $extensions = array("doc", "docx", "txt", "pdf", "zip");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Extension not allowed";
            }

            if ($file_size > 10000000) {
                $errors[] = 'File size must be less than 2 MB';
            }

            if (empty($errors) == true) {
                $newName = $newID . "_" . $file_name;
                move_uploaded_file($file_tmp, "./uploads/$newName");
                $article_attachment_md = "uploads/$newName";
                $retrieveThis = $this->extractData("uploads/$newName");
                //print_r($retrieveThis);
                //exit;
                $article_name = $retrieveThis["Headline"];
                $article_created = $retrieveThis["DateCreated"];
                $article_wordcount_md = $retrieveThis["WordCount"];
                $article_description = $retrieveThis["Description"];
                $article_keywords = $retrieveThis["Keywords"];
            } else {
                echo "<p>There were some errors in your upload:</p>";
                print_r($errors);
            }
        } else {
            $article_attachment_md = null;
        }

        if (!empty($article_attachment_lg["tmp_name"])) {

            $newID = rand();

            $errors = array();
            $file_name = $article_attachment_lg['name'];
            $file_size = $article_attachment_lg['size'];
            $file_tmp = $article_attachment_lg['tmp_name'];
            $file_type = $article_attachment_lg['type'];
            $cleanMe = explode('.', $file_name);
            $file_ext = strtolower(end($cleanMe));

            $extensions = array("doc", "docx", "txt", "pdf", "zip");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Extension not allowed";
            }

            if ($file_size > 10000000) {
                $errors[] = 'File size must be less than 2 MB';
            }

            if (empty($errors) == true) {
                $newName = $newID . "_" . $file_name;
                move_uploaded_file($file_tmp, "./uploads/$newName");

                $article_attachment_lg = "uploads/$newName";
                $retrieveThis = $this->extractData("uploads/$newName");
                //print_r($retrieveThis);
                //exit;
                $article_name = $retrieveThis["Headline"];
                $article_created = $retrieveThis["DateCreated"];
                $article_wordcount_lg = $retrieveThis["WordCount"];
                $article_description = $retrieveThis["Description"];
                $article_keywords = $retrieveThis["Keywords"];
            } else {
                echo "<p>There were some errors in your upload:</p>";
                print_r($errors);
            }
        }

        if (!empty($article_created)) {
            $article_created = date("Y-m-d", strtotime($article_created));
        }

        if (!empty($article_image_sm["tmp_name"])) {

            $newID = rand();

            $errors = array();
            $file_name = $article_image_sm['name'];
            $file_size = $article_image_sm['size'];
            $file_tmp = $article_image_sm['tmp_name'];
            $file_type = $article_image_sm['type'];
            $cleanMe = explode('.', $file_name);
            $file_ext = strtolower(end($cleanMe));

            $extensions = array("jpg", "jpeg", "gif", "bmp", "png");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Extension not allowed";
            }

            if ($file_size > 10000000) {
                $errors[] = 'File size must be less than 2 MB';
            }

            if (empty($errors) == true) {
                $newName = $newID . "_" . $file_name;
                move_uploaded_file($file_tmp, "./uploads/$newName");
                $article_image_sm = "uploads/$newName";
            } else {
                echo "<p>There were some errors in your upload:</p>";
                print_r($errors);
            }
        } else {
            $article_image_sm = null;
        }

        if (!empty($article_image_md["tmp_name"])) {

            $newID = rand();

            $errors = array();
            $file_name = $article_image_md['name'];
            $file_size = $article_image_md['size'];
            $file_tmp = $article_image_md['tmp_name'];
            $file_type = $article_image_md['type'];
            $cleanMe = explode('.', $file_name);
            $file_ext = strtolower(end($cleanMe));

            $extensions = array("jpg", "jpeg", "gif", "bmp", "png");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Extension not allowed";
            }

            if ($file_size > 10000000) {
                $errors[] = 'File size must be less than 2 MB';
            }

            if (empty($errors) == true) {
                $newName = $newID . "_" . $file_name;
                move_uploaded_file($file_tmp, "./uploads/$newName");
                $article_image_md = "uploads/$newName";
            } else {
                echo "<p>There were some errors in your upload:</p>";
                print_r($errors);
            }
        } else {
            $article_image_md = null;
        }

        if (!empty($article_image_lg["tmp_name"])) {

            $newID = rand();

            $errors = array();
            $file_name = $article_image_lg['name'];
            $file_size = $article_image_lg['size'];
            $file_tmp = $article_image_lg['tmp_name'];
            $file_type = $article_image_lg['type'];
            $cleanMe = explode('.', $file_name);
            $file_ext = strtolower(end($cleanMe));

            $extensions = array("jpg", "jpeg", "gif", "bmp", "png");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Extension not allowed";
            }

            if ($file_size > 10000000) {
                $errors[] = 'File size must be less than 2 MB';
            }

            if (empty($errors) == true) {
                $newName = $newID . "_" . $file_name;
                move_uploaded_file($file_tmp, "./uploads/$newName");
                $article_image_lg = "uploads/$newName";
            } else {
                echo "<p>There were some errors in your upload:</p>";
                print_r($errors);
            }
        } else {
            $article_image_lg = null;
        }

        $data = array(
            //'id'					=> $modID,
            'article_name' => $article_name,
            'article_category' => $article_category,
            'article_description' => $article_description,
            'article_wordcount_sm' => $article_wordcount_sm,
            'article_wordcount_md' => $article_wordcount_md,
            'article_wordcount_lg' => $article_wordcount_lg,
            'article_keywords' => $article_keywords,
            'article_demographic' => $article_demographic,
            'article_uploaded' => $article_uploaded,
            'article_created' => $article_created
        );

        if (!empty($article_attachment_sm)) {
            $data['article_attachment_sm'] = $article_attachment_sm;
        }
        if (!empty($article_attachment_md)) {
            $data['article_attachment_md'] = $article_attachment_md;
        }
        if (!empty($article_attachment_lg)) {
            $data['article_attachment_lg'] = $article_attachment_lg;
        }
        if (!empty($article_image_sm)) {
            $data['article_image_sm'] = $article_image_sm;
        }
        if (!empty($article_image_md)) {
            $data['article_image_md'] = $article_image_md;
        }
        if (!empty($article_image_lg)) {
            $data['article_image_lg'] = $article_image_lg;
        }

        $this->db->insert('articles', $data);

        $_SESSION["DisplayMessage"] = "Record added successfully.";

        redirect("articles/view/add");
    }

    public function addBasic() {

        $article_name = $_POST["article_name"];
        $article_attachment_sm = $_FILES["article_attachment_sm"];
        $article_attachment_md = $_FILES["article_attachment_md"];
        $article_attachment_lg = $_FILES["article_attachment_lg"];
        $article_image_sm = $_FILES["article_image_sm"];
        $article_image_md = $_FILES["article_image_md"];
        $article_image_lg = $_FILES["article_image_lg"];
        $article_category = $_POST["article_category"];
        if (!empty($article_category)) {
            $article_category = implode(",", $article_category);
        }
        $article_description = $_POST["article_description"];
        $article_wordcount_sm = $_POST["article_wordcount_sm"];
        $article_wordcount_md = $_POST["article_wordcount_md"];
        $article_wordcount_lg = $_POST["article_wordcount_lg"];
        $article_keywords = $_POST["article_keywords"];
        $article_demographic = $_POST["article_demographic"];
        if (!empty($article_demographic)) {
            $article_demographic = implode(",", $article_demographic);
        }
        $article_uploaded = date('Y-m-d');
        $article_created = $_POST["article_created"];

        $modID = null;

        if (!empty($article_attachment_sm["tmp_name"])) {

            $newID = rand();

            $errors = array();
            $file_name = $article_attachment_sm['name'];
            $file_size = $article_attachment_sm['size'];
            $file_tmp = $article_attachment_sm['tmp_name'];
            $file_type = $article_attachment_sm['type'];
            $cleanMe = explode('.', $file_name);
            $file_ext = strtolower(end($cleanMe));

            $extensions = array("doc", "docx", "txt", "pdf", "zip");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Extension not allowed: $file_ext";
            }

            if ($file_size > 10000000) {
                $errors[] = 'File size must be less than 2 MB';
            }

            if (empty($errors) == true) {
                $newName = $newID . "_" . $file_name;
                move_uploaded_file($file_tmp, "./uploads/$newName");
                $article_attachment_sm = "uploads/$newName";
                $retrieveThis = $this->extractData("uploads/$newName");
                //print_r($retrieveThis);
                //exit;
                $article_name = $retrieveThis["Headline"];
                $article_created = $retrieveThis["DateCreated"];
                $article_wordcount_sm = $retrieveThis["WordCount"];
                $article_description = $retrieveThis["Description"];
                $article_keywords = $retrieveThis["Keywords"];
            } else {
                echo "<p>There were some errors in your upload:</p>";
                print_r($errors);
            }
        } else {
            $article_attachment_sm = null;
        }

        if (!empty($article_attachment_md["tmp_name"])) {

            //$newID = rand();

            $errors = array();
            $file_name = $article_attachment_md['name'];
            $file_size = $article_attachment_md['size'];
            $file_tmp = $article_attachment_md['tmp_name'];
            $file_type = $article_attachment_md['type'];
            $cleanMe = explode('.', $file_name);
            $file_ext = strtolower(end($cleanMe));

            $extensions = array("doc", "docx", "txt", "pdf", "zip");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Extension not allowed";
            }

            if ($file_size > 10000000) {
                $errors[] = 'File size must be less than 2 MB';
            }

            if (empty($errors) == true) {
                $newName = $newID . "_" . $file_name;
                move_uploaded_file($file_tmp, "./uploads/$newName");
                $article_attachment_md = "uploads/$newName";
                $retrieveThis = $this->extractData("uploads/$newName");
                //print_r($retrieveThis);
                //exit;
                $article_name = $retrieveThis["Headline"];
                $article_created = $retrieveThis["DateCreated"];
                $article_wordcount_md = $retrieveThis["WordCount"];
                $article_description = $retrieveThis["Description"];
                $article_keywords = $retrieveThis["Keywords"];
            } else {
                echo "<p>There were some errors in your upload:</p>";
                print_r($errors);
            }
        } else {
            $article_attachment_md = null;
        }

        if (!empty($article_attachment_lg["tmp_name"])) {

            $newID = rand();

            $errors = array();
            $file_name = $article_attachment_lg['name'];
            $file_size = $article_attachment_lg['size'];
            $file_tmp = $article_attachment_lg['tmp_name'];
            $file_type = $article_attachment_lg['type'];
            $cleanMe = explode('.', $file_name);
            $file_ext = strtolower(end($cleanMe));

            $extensions = array("doc", "docx", "txt", "pdf", "zip");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Extension not allowed";
            }

            if ($file_size > 10000000) {
                $errors[] = 'File size must be less than 2 MB';
            }

            if (empty($errors) == true) {
                $newName = $newID . "_" . $file_name;
                move_uploaded_file($file_tmp, "./uploads/$newName");

                $article_attachment_lg = "uploads/$newName";
                $retrieveThis = $this->extractData("uploads/$newName");
                //print_r($retrieveThis);
                //exit;
                $article_name = $retrieveThis["Headline"];
                $article_created = $retrieveThis["DateCreated"];
                $article_wordcount_lg = $retrieveThis["WordCount"];
                $article_description = $retrieveThis["Description"];
                $article_keywords = $retrieveThis["Keywords"];
            } else {
                echo "<p>There were some errors in your upload:</p>";
                print_r($errors);
            }
        } else {
            $article_attachment_lg = null;
        }

        if (!empty($article_created)) {
            $article_created = date("Y-m-d", strtotime($article_created));
        }

        if (!empty($article_image_sm["tmp_name"])) {

            $newID = rand();

            $errors = array();
            $file_name = $article_image_sm['name'];
            $file_size = $article_image_sm['size'];
            $file_tmp = $article_image_sm['tmp_name'];
            $file_type = $article_image_sm['type'];
            $cleanMe = explode('.', $file_name);
            $file_ext = strtolower(end($cleanMe));

            $extensions = array("jpg", "jpeg", "gif", "bmp", "png");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Extension not allowed";
            }

            if ($file_size > 10000000) {
                $errors[] = 'File size must be less than 2 MB';
            }

            if (empty($errors) == true) {
                $newName = $newID . "_" . $file_name;
                move_uploaded_file($file_tmp, "./uploads/$newName");
                $article_image_sm = "uploads/$newName";
            } else {
                echo "<p>There were some errors in your upload:</p>";
                print_r($errors);
            }
        } else {
            $article_image_sm = null;
        }

        if (!empty($article_image_md["tmp_name"])) {

            $newID = rand();

            $errors = array();
            $file_name = $article_image_md['name'];
            $file_size = $article_image_md['size'];
            $file_tmp = $article_image_md['tmp_name'];
            $file_type = $article_image_md['type'];
            $cleanMe = explode('.', $file_name);
            $file_ext = strtolower(end($cleanMe));

            $extensions = array("jpg", "jpeg", "gif", "bmp", "png");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Extension not allowed";
            }

            if ($file_size > 10000000) {
                $errors[] = 'File size must be less than 2 MB';
            }

            if (empty($errors) == true) {
                $newName = $newID . "_" . $file_name;
                move_uploaded_file($file_tmp, "./uploads/$newName");
                $article_image_md = "uploads/$newName";
            } else {
                echo "<p>There were some errors in your upload:</p>";
                print_r($errors);
            }
        } else {
            $article_image_md = null;
        }

        if (!empty($article_image_lg["tmp_name"])) {

            $newID = rand();

            $errors = array();
            $file_name = $article_image_lg['name'];
            $file_size = $article_image_lg['size'];
            $file_tmp = $article_image_lg['tmp_name'];
            $file_type = $article_image_lg['type'];
            $cleanMe = explode('.', $file_name);
            $file_ext = strtolower(end($cleanMe));

            $extensions = array("jpg", "jpeg", "gif", "bmp", "png");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Extension not allowed";
            }

            if ($file_size > 10000000) {
                $errors[] = 'File size must be less than 2 MB';
            }

            if (empty($errors) == true) {
                $newName = $newID . "_" . $file_name;
                move_uploaded_file($file_tmp, "./uploads/$newName");
                $article_image_lg = "uploads/$newName";
            } else {
                echo "<p>There were some errors in your upload:</p>";
                print_r($errors);
            }
        } else {
            $article_image_lg = null;
        }

        $data = array(
            //'id'					=> $modID,
            'article_name' => $article_name,
            'article_category' => $article_category,
            'article_description' => $article_description,
            'article_wordcount_sm' => $article_wordcount_sm,
            'article_wordcount_md' => $article_wordcount_md,
            'article_wordcount_lg' => $article_wordcount_lg,
            'article_keywords' => $article_keywords,
            'article_demographic' => $article_demographic,
            'article_uploaded' => $article_uploaded,
            'article_created' => $article_created
        );

        if (!empty($article_attachment_sm)) {
            $data['article_attachment_sm'] = $article_attachment_sm;
        }
        if (!empty($article_attachment_md)) {
            $data['article_attachment_md'] = $article_attachment_md;
        }
        if (!empty($article_attachment_lg)) {
            $data['article_attachment_lg'] = $article_attachment_lg;
        }
        if (!empty($article_image_sm)) {
            $data['article_image_sm'] = $article_image_sm;
        }
        if (!empty($article_image_md)) {
            $data['article_image_md'] = $article_image_md;
        }
        if (!empty($article_image_lg)) {
            $data['article_image_lg'] = $article_image_lg;
        }

        $this->db->insert('articles', $data);

        $_SESSION["DisplayMessage"] = "Record added successfully.";

        redirect("articles/view/add");
    }
}
