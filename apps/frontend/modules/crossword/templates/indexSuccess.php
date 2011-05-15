<h1>Crosswords List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Category</th>
      <th>Title</th>
      <th>Description</th>
      <th>Is public</th>
      <th>Is activated</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($crosswords as $crossword): ?>
    <tr>
      <td><a href="<?php echo url_for('crossword/show?id='.$crossword->getId()) ?>"><?php echo $crossword->getId() ?></a></td>
      <td><?php echo $crossword->getCategoryId() ?></td>
      <td><?php echo $crossword->getTitle() ?></td>
      <td><?php echo $crossword->getDescription() ?></td>
      <td><?php echo $crossword->getIsPublic() ?></td>
      <td><?php echo $crossword->getIsActivated() ?></td>
      <td><?php echo $crossword->getCreatedAt() ?></td>
      <td><?php echo $crossword->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('crossword/new') ?>">New</a>
