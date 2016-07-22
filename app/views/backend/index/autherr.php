<?php
    use Roko\Helper\BS;
    use Roko\Helper\Html;
?>

<article>
    <header><h1 class="page-header"><?=$page_header??''?></h1></header>

    <?php
        if ($data) {

            foreach ($data as $k=>$row) {
                $data[$k][] = function() use ($row) {
                    return Html::a(
                        'admin/index/autherr?delete='.$row['id'],
                        'Delete',
                        [
                            'class'=>'btn btn-xs btn-danger',
                            'onclick'=>'if (!confirm(\'Delete element?\')) return false;',
                        ]
                    );
                };
                unset($data[$k]['id']);
            }

            echo BS::table(
                ['User ip', 'Errors', 'Manage'],
                $data,
                ['class'=>'table-striped table-bordered']
            );

            echo BS::pagination($pagination??[], 'admin/index/autherr');
        } else {
            echo '<p>No data yet<p>';
        }
     ?>

</article>