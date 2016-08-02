<?php
$this->load->helper('form');

// Form
$formData = array(
    'class' => 'frmArticle',
    'id' => 'frmArticle'
);

// Article Name
$formArticleName = array(
    'name' => 'article_name',
    'id' => 'article_name',
    'placeholder' => 'article name',
    'maxlength' => '50',
    'size' => '25',
    'class' => 'clearfix'
);

$formArticleCreated = array(
    'name' => 'article_created',
    'id' => 'article_created',
    'placeholder' => '01/04/2010',
    'class' => 'dateMe'
);

$formArticleAttachment_sm = array(
    'name' => 'article_attachment_sm',
    'id' => 'article_attachment_sm',
    'placeholder' => 'attachment',
    'class' => 'clearfix'
);

$formArticleAttachment_md = array(
    'name' => 'article_attachment_md',
    'id' => 'article_attachment_md',
    'placeholder' => 'attachment',
    'class' => 'clearfix'
);

$formArticleAttachment_lg = array(
    'name' => 'article_attachment_lg',
    'id' => 'article_attachment_lg',
    'placeholder' => 'attachment',
    'class' => 'clearfix'
);

$formArticleImage_sm = array(
    'name' => 'article_image_sm',
    'id' => 'article_image_sm',
    'placeholder' => 'image',
    'class' => 'clearfix'
);

$formArticleImage_md = array(
    'name' => 'article_image_md',
    'id' => 'article_image_md',
    'placeholder' => 'image',
    'class' => 'clearfix'
);

$formArticleImage_lg = array(
    'name' => 'article_image_lg',
    'id' => 'article_image_lg',
    'placeholder' => 'image',
    'class' => 'clearfix'
);

$formArticleDescription = array(
    'name' => 'article_description',
    'id' => 'article_description',
    'rows' => '5',
    'cols' => '50'
);

// Article Word Count
$formArticleWordCount_sm = array(
    'name' => 'article_wordcount_sm',
    'id' => 'article_wordcount_sm',
    'placeholder' => 'word count',
    'maxlength' => '9',
    'size' => '12',
    'class' => 'clearfix'
);

$formArticleWordCount_md = array(
    'name' => 'article_wordcount_md',
    'id' => 'article_wordcount_md',
    'placeholder' => 'word count',
    'maxlength' => '9',
    'size' => '12',
    'class' => 'clearfix'
);

$formArticleWordCount_lg = array(
    'name' => 'article_wordcount_lg',
    'id' => 'article_wordcount_lg',
    'placeholder' => 'word count',
    'maxlength' => '9',
    'size' => '12',
    'class' => 'clearfix'
);

$formArticleKeywords = array(
    'name' => 'article_keywords',
    'id' => 'article_keywords',
    'placeholder' => 'key words separated by comma',
    'maxlength' => '100',
    'size' => '50',
    'class' => 'clearfix'
);

$formArticleDemographicOptions = "<div>";
foreach ($demographics as $item) {
    $label = $item["label"];
    $value = $item["uid"];

    $formArticleDemographicOptions .= "<div class='checkbox_wrapper'><input type='checkbox' name='article_demographic[]' value='$value' />&nbsp;$label</div>";
    /* if($item["label"]==$article_demographic) {
      $formArticleDemographicOptions .= " selected='selected'";
      } */
}
$formArticleDemographicOptions .= "</div>";

$formArticleTypeOptions = "<div>";
foreach ($article_types as $item) {
    $label = $item["Label"];
    $value = $item["UID"];

    $formArticleTypeOptions .= "<div class='checkbox_wrapper'><input type='checkbox' name='article_category[]' value='$value' />&nbsp;$label</div>";
}
$formArticleTypeOptions .= "</div>";

$formSubmit = array(
    'name' => 'submit',
    'id' => 'submit',
    'value' => 'Add'
);

echo anchor("/Articles/view", "Cancel");
?>
<div class="tabs">
    <ul>
        <li><a href="#tabs-1">Add Article</a></li>
        <li><a href="#tabs-2">Add Dynamic Article</a></li>
    </ul>
    <div id="tabs-1">
        <?php echo form_open_multipart('articles/addBasic', $formData); ?>
        <table class="tblArticleDetails" cellpadding="3" cellspacing="0">
            <tr>
                    <td>Article Name</td>
                    <td><?php echo form_input($formArticleName); ?></td>
            </tr>
            <tr>
                    <td>Date Created</td>
                    <td><?php echo form_input($formArticleCreated); ?></td>
            </tr>
            <tr>
                <td>Attachment (sm)</td>
                <td>
                    <?php echo form_upload($formArticleAttachment_sm); ?>
                </td>
            </tr>
            <tr>
                <td>Image (sm)</td>
                <td>
                    <?php echo form_upload($formArticleImage_sm); ?>
                </td>
            </tr>
            <tr>
                    <td>Word Count (sm)</td>
                    <td>
                        <?php echo form_input($formArticleWordCount_sm); ?>
                    </td>
            </tr>
            <tr>
                <td>Attachment (md)</td>
                <td>
                    <?php echo form_upload($formArticleAttachment_md); ?>
                </td>
            </tr>
            <tr>
                <td>Image (md)</td>
                <td>
                    <?php echo form_upload($formArticleImage_md); ?>
                </td>
            </tr>
            <tr>
                    <td>Word Count (md)</td>
                    <td>
                        <?php echo form_input($formArticleWordCount_md); ?>
                    </td>
            </tr>
            <tr>
                <td>Attachment (lg)</td>
                <td>
                    <?php echo form_upload($formArticleAttachment_lg); ?>
                </td>
            </tr>
            <tr>
                <td>Image (lg)</td>
                <td>
                    <?php echo form_upload($formArticleImage_lg); ?>
                </td>
            </tr>
            <tr>
                    <td>Word Count (lg)</td>
                    <td>
                        <?php echo form_input($formArticleWordCount_lg); ?>
                    </td>
            </tr>
            <tr>
                <td>Article Type</td>
                <td>
                    <?php echo $formArticleTypeOptions; ?>
                </td>
            </tr>
            <tr>
                    <td>Keywords</td>
                    <td><?php echo form_input($formArticleKeywords); ?></td>
            </tr>
            <tr>
                    <td>Description</td>
                    <td><?php echo form_textarea($formArticleDescription); ?></td>
            </tr>
            <tr>
                <td>Demographic</td>
                <td>
                    <?php echo $formArticleDemographicOptions; ?>
                </td>
            </tr>
        </table>
        <?php
        echo form_submit('add', 'Add');
        
        echo form_close();
        ?>
    </div>
    <div id="tabs-2">
        <?php echo form_open_multipart('articles/add', $formData); ?>
        <table class="tblArticleDetails" cellpadding="3" cellspacing="0">
            <!--
            <tr>
                    <td>Article Name</td>
                    <td><?php echo form_input($formArticleName); ?></td>
            </tr>
            <tr>
                    <td>Date Created</td>
                    <td><?php echo form_input($formArticleCreated); ?></td>
            </tr>
            -->
            <tr>
                <td>Attachment (sm)</td>
                <td>
                    <?php echo form_upload($formArticleAttachment_sm); ?>
                </td>
            </tr>
            <tr>
                <td>Image (sm)</td>
                <td>
                    <?php echo form_upload($formArticleImage_sm); ?>
                </td>
            </tr>
            <!--
            <tr>
                    <td>Word Count (sm)</td>
                    <td>
                        <?php echo form_input($formArticleWordCount_sm); ?>
                    </td>
            </tr>
            -->
            <tr>
                <td>Attachment (md)</td>
                <td>
                    <?php echo form_upload($formArticleAttachment_md); ?>
                </td>
            </tr>
            <tr>
                <td>Image (md)</td>
                <td>
                    <?php echo form_upload($formArticleImage_md); ?>
                </td>
            </tr>
            <!--
            <tr>
                    <td>Word Count (md)</td>
                    <td>
                        <?php echo form_input($formArticleWordCount_md); ?>
                    </td>
            </tr>
            -->
            <tr>
                <td>Attachment (lg)</td>
                <td>
                    <?php echo form_upload($formArticleAttachment_lg); ?>
                </td>
            </tr>
            <tr>
                <td>Image (lg)</td>
                <td>
                    <?php echo form_upload($formArticleImage_lg); ?>
                </td>
            </tr>
            <!--
            <tr>
                    <td>Word Count (lg)</td>
                    <td>
                        <?php echo form_input($formArticleWordCount_lg); ?>
                    </td>
            </tr>
            -->
            <tr>
                <td>Article Type</td>
                <td>
                    <?php echo $formArticleTypeOptions; ?>
                </td>
            </tr>
            <!--
            <tr>
                    <td>Keywords</td>
                    <td><?php echo form_input($formArticleKeywords); ?></td>
            </tr>
            <tr>
                    <td>Description</td>
                    <td><?php echo form_textarea($formArticleDescription); ?></td>
            </tr>
            -->
            <tr>
                <td>Demographic</td>
                <td>
                    <?php echo $formArticleDemographicOptions; ?>
                </td>
            </tr>
        </table>
        <?php
        echo form_submit('add', 'Add');

        echo form_close();
        ?>
    </div>
</div>