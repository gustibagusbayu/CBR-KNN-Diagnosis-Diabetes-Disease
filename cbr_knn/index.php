<?php 
    include'koneksi.php';

    $query = mysqli_query($koneksi, "SELECT * FROM data_training");



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
                            <a class="nav-link active" href="index.php"
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
                            <a class="nav-link" href="kasus_baru.php"
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
                        <h1 class="mt-4">Tabel Data Training</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Training</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header"><i class="fas fa-table mr-1"></i>Data Training</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Id Kasus</th>
                                                <th>Preg</th>
                                                <th>Glu</th>
                                                <th>Bp</th>
                                                <th>Skin</th>
                                                <th>Insulin</th>
                                                <th>BMI</th>
                                                <th>DPF</th>
                                                <th>Age</th>
                                                <th>Outcome</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($data = mysqli_fetch_array($query)) {?>
                                            <tr>
                                                <td><?= $data['id_case']; ?></td>
                                                <td><?= $data['preg']; ?></td>
                                                <td><?= $data['glu']; ?></td>
                                                <td><?= $data['bp']; ?></td>
                                                <td><?= $data['skin']; ?></td>
                                                <td><?= $data['insulin']; ?></td>
                                                <td><?= $data['bmi']; ?></td>
                                                <td><?= $data['dpf']; ?></td>
                                                <td><?= $data['age']; ?></td>
                                                <td><?= $data['outcome']; ?></td>
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
