<div class="create">
  <h2>Create a Post</h2>

  <form enctype="multipart/form-data" action="/new-post" method="POST">
    <input type="title" name="title" placeholder="Title">
    <input type="file" name="image">
    <textarea name="content" placeholder="Content"></textarea>
    <input type="submit" value="Post">
  </form>
</div>