<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $crossword->getId() ?></td>
    </tr>
    <tr>
      <th>Category:</th>
      <td><?php echo $crossword->getCategoryId() ?></td>
    </tr>
    <tr>
      <th>Title:</th>
      <td><?php echo $crossword->getTitle() ?></td>
    </tr>
    <tr>
      <th>Description:</th>
      <td><?php echo $crossword->getDescription() ?></td>
    </tr>
    <tr>
      <th>Is public:</th>
      <td><?php echo $crossword->getIsPublic() ?></td>
    </tr>
    <tr>
      <th>Is activated:</th>
      <td><?php echo $crossword->getIsActivated() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $crossword->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $crossword->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('crossword/edit?id='.$crossword->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('crossword/index') ?>">List</a>
