<?php


class Template
{
    public static function showHeader($pageName, $path = "")
    {
        ?>
        <html lang="en">
        <head>
            <link rel="stylesheet" href="<?= $path ?>_assets/css/bootstrap.css">
            <link rel="stylesheet" href="<?= $path ?>_assets/css/cac_main.css">
            <link rel="stylesheet" href="<?= $path ?>_assets/css/generate-report.css">
            <title><?= $pageName ?></title>
        </head>


        <?php
    }

    public static function showFooter($path = "")
    {
        ?>
        </html>
        <?php
    }

    public static function addScript($filename)
    {
        echo("<script src='$filename'></script>");
    }

    public static function genNavBar($linkPaths, $linkNames)
    {
        if (!is_array($linkPaths)) {
            throw new Exception("Expecting array of filepaths");
        }
        if(!is_array($linkNames)){
            $linkNames = [];
            for($i = 0; $i < count($linkPaths); $i++){
                $linkNames[$i] = "error_".$i;
            }
        }
        ?>
        <div class="row nav-container" id="nav_bar">
            <nav class="">
                <ul>
                    <?php
                    for($i = 0; $i < count($linkPaths); $i++){
                        ?>
                        <li><a href="<?= $linkPaths[$i] ?>"><?= $linkNames[$i] ?></a></li>
                        <?php
                    }
                    ?>
                </ul>
            </nav>
        </div>
        <?php
    }

}