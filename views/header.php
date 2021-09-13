<?php
/**
 *
 * @author Adolfo Jiménez <isc.adolfojimenez@gmail.com>
 * @date 12 sep. 2021
 * @time 3:21:13
 */
$menusOrdered = [];
if (isset($this->d['ordered'])) {
    $menusOrdered = $this->d['ordered'];
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<link href="../resources/css/fontawesome/css/all.min.css" rel="stylesheet" type="text/css"/>
<div id="header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo constant('URL'); ?>home">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo constant('URL'); ?>menu">Menú <span class="sr-only">(current)</span></a>
                </li>
                <?php
                foreach ($menusOrdered as $padre) {
                    $childs = $padre->getChilds();
                    if (!empty($childs)) {
                        echo '<li class="nav-item dropdown">';
                        echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$padre->getNombre().'</a>';
                        echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                        foreach ($childs as $hijo) {
                            echo '<a class="dropdown-item" href="#">'.$hijo->getNombre().'</a>';
                        }
                        echo '</div>';
                        echo '</li>';
                    } else {
                        echo '<li class="nav-item active">';
                        echo '<a class="nav-link" href="#">'.$padre->getNombre().'</a>';
                        echo '</li>';
                    }
                }
                ?>
            </ul>
        </div>
    </nav>
</div>