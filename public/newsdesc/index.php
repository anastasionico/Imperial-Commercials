<?php include('../perch/runtime.php');

perch_layout('global.top');
?>
<div class="container">
  <div class="page">

    <div class="tile tile-grey tile-padded">
      <div class="row">
        <div class="col-md-6">
          <?php perch_content('Top Image 1'); ?>
        </div><!-- /.col -->
        <div class="col-md-6">
          <?php perch_content('Top Text'); ?>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div>



    <div class="row">
      <div class="col-md-12">

        <h1>News</h1>
        <!-- this is an example blog homepage showing a simple call to perch_blog_recent_posts()

          Posts are displayed using the templates stored in perch/apps/perch_blog/templates/blog you can edit these as you wish, making sure that the 
          paths used in these templates are correct for your installation.
           -->
        <?php 
        perch_blog_recent_posts(10);
        ?>

        <p><a href="archive.php">More posts</a></p>

      </div>
<?/*
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
 */?>

    </div>

  </div>
</div>

<?php
perch_layout('global.bottom');
?>
