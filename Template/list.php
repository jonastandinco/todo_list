<h2>TODO List</h2>
<a href="index.php?action=add">New</a>
<?php if (count($items)) : ?>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item) : ?>
                <tr>
                    <td><?php echo $item->getId() ?></td>
                    <td>
                        <?php if ($item->isCompleted()) : ?>
                            <del><?php echo $item->getName() ?></del>
                        <?php else : ?>
                            <?php echo $item->getName() ?>
                        <?php endif ?>
                    </td>
                    <td><?php echo App\Model\ToDoItem::toStatusName($item->getStatus()) ?></td>
                    <td>
                        <form>
                            <?php if ($item->isActive()) : ?>
                                <a href="index.php?action=complete&id=<?php echo $item->getId() ?>">Complete</a>
                            <?php else : ?>
                                <a href="index.php?action=activate&id=<?php echo $item->getId() ?>">Activate</a>
                            <?php endif ?>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
<?php else : ?>
    <p>There are no items.</p>
<?php endif ?>