<?php 
    include'koneksi.php';
    $query = mysqli_query($koneksi, "SELECT * FROM kasus_baru");

    function normalisasi($min, $max, $data){
        $hasil = ($data-$min)/($max-$min);
        $hasil_format = number_format($hasil,3);
        return $hasil_format;
    }

    // revise
    if(isset($_GET["id_newCase"])){
        $id_newCase = $_GET["id_newCase"];
        
        $query1 = mysqli_query($koneksi, "SELECT preg, glu, bp, skin, insulin, bmi, dpf, age, outcome FROM kasus_baru WHERE id_newCase = '$id_newCase'");
        while($revise = mysqli_fetch_array($query1)) {
            for($x=0;$x<8;$x++){
            $konversi[$x] = floatval($revise[$x]);
            if($x==0){
                $preg = normalisasi(0,17,$konversi[0]);
            } elseif($x==1){
                $glu = normalisasi(0,199,$konversi[1]);
            } elseif($x==2){
                $bp = normalisasi(0,122,$konversi[2]);
            } elseif($x==3){
                $skin = normalisasi(0,99,$konversi[3]);
            } elseif($x==4){
                $insulin = normalisasi(0,846,$konversi[4]);
            } elseif($x==5){
                $bmi = normalisasi(0,67.1,$konversi[5]);
            } elseif($x==6){
                $dpf = normalisasi(0.078,2329,$konversi[6]);
            } elseif($x==7){
                $age = normalisasi(21,81,$konversi[7]);
            }
            $out = $revise['outcome'];
        }
    }

    $exe = mysqli_query($koneksi, "INSERT INTO data_training VALUES('', '$preg', '$glu', '$bp', '$skin', '$insulin', '$bmi', '$dpf', '$age', '$out' )");
    if (!$exe) {
        die('Query Error : ' . mysqli_errno($koneksi) . '-' . mysqli_error($koneksi));
    } 

    $delete = mysqli_query($koneksi, "DELETE FROM kasus_baru WHERE id_newCase = '$id_newCase'");
    if (!$delete) {
        die('Query Error : ' . mysqli_errno($koneksi) . '-' . mysqli_error($koneksi));
    } else {
        echo "
        <script>
                    alert('Kasus Baru Berhasil Ditambahkan ke Basis Kasus!');
                    document.location.href = 'index.php';
            </script>	
        ";
    }

    }


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>CBR KNN</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">CBR KNN Diagnosis Penyakit Diabetes</a>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">DASHBOARD</div>
                            <a class="nav-link" href="index.php"
                                ><div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Data Training</a
                            >
                            <a class="nav-link" href="input.php"
                                ><div class="sb-nav-link-icon"><i class="fas fa-keyboard"></i></div>
                                Input Kasus Baru</a 
                            >
                            <a class="nav-link" href="proses.php"
                                ><div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                                Hasil Diagnosis</a 
                            >
                            <a class="nav-link active" href="kasus_baru.php"
                                ><div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                                Kasus Baru</a 
                            >
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Tabel Kasus Baru</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Kasus Baru</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header"><i class="fas fa-table mr-1"></i>Kasus Baru</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Id Kasus Baru</th>
                                                <th>Preg</th>
                                                <th>Glu</th>
                                                <th>Bp</th>
                                                <th>Skin</th>
                                                <th>Insulin</th>
                                                <th>BMI</th>
                                                <th>DPF</th>
                                                <th>Age</th>
                                                <th>Outcome</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($data = mysqli_fetch_array($query)) {?>
                                            <tr>
                                                <td><?= $data['id_newCase']; ?></td>
                                                <td><?= $data['preg']; ?></td>
                                                <td><?= $data['glu']; ?></td>
                                                <td><?= $data['bp']; ?></td>
                                                <td><?= $data['skin']; ?></td>
                                                <td><?= $data['insulin']; ?></td>
                                                <td><?= $data['bmi']; ?></td>
                                                <td><?= $data['dpf']; ?></td>
                                                <td><?= $data['age']; ?></td>
                                                <td><?= $data['outcome']; ?></td>
                                                <td><a href="kasus_baru.php?id_newCase=<?= $data['id_newCase']; ?>" class="badge badge-success">Konfirmasi</a></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Bayu Adi Pramana 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>
