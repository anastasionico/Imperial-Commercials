<?php include('../perch/runtime.php');

perch_layout('global.top');
?>
<div class="container">
  <div class="page">

    <div class="row">
      <div class="col-md-9">
        <div class="post">
          <?php perch_blog_post(perch_get('s')); ?>

          <div class="meta">
            <div class="cats">
              <?php perch_blog_post_categories(perch_get('s')); ?>
            </div>
            <div class="tags">
              <?php perch_blog_post_tags(perch_get('s')); ?>
            </div>
          </div>

          <?php perch_blog_post_comments(perch_get('s')); ?>

          <?php perch_blog_post_comment_form(perch_get('s')); ?>
        </div>
      </div>
      <div class="col-md-3">

        <nav class="sidebar">
          <h2>Archive</h2>
          <!-- The following functions are different ways to display archives. You can use any or all of these. 

          All of these functions can take a parameter of a template to overwrite the default template, for example:

          perch_blog_categories('my_template.html');

          --> 
          <!--  By category listing -->
          <?php perch_blog_categories(); ?>
          <!--  By tag -->
          <?php perch_blog_tags(); ?>
          <!--  By year -->
          <?php perch_blog_date_archive_years(); ?>
          <!--  By year and then month - can take parameters for two templates. The first displays the years and the second the months see the default templates for examples -->
          <?php perch_blog_date_archive_months(); ?>
        </nav>
      </div>
    </div>
  </div>
</div>
<?php
perch_layout('global.bottom');
?>
