<?php

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['filePathVisualiser']))
              {
                $file = $_POST['filePathVisualiser'];
                $filename = $file;
                header('Content-type: application/pdf');
                header('Content-Disposition: inline; filename="' . $filename . '"');
                header('Content-Transfer-Encoding: binary');
                header('Content-Length: ' . filesize($file));
                header('Accept-Ranges: bytes');
                @readfile($file);
              }