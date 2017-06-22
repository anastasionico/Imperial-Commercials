<div class="container pad-bottom">
  <div class="row">
    <div class="col-xs-12">
      <h1>Blog</h1>
      <div class="textbox-white">

        <div class="row">
          <div class="col-xs-12 col-md-12">
            <? if(! empty($blogs) ) { ?>
              <? foreach($blogs as $blog) { ?>
                <h2><a href="/blog/<?=$blog['id']?>"><?=$blog['name']?></a></h2>
                <?=$blog['content']?>
              <? } ?>
            <? } else { ?>
              <p>There are currently no posts</p>
            <? } ?>
          </div>
        </div>

      </div>
    </div>
  </div><!-- /.row -->
</div><!-- /.container -->
