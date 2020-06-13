<?php 
    include'koneksi.php';


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
                            <a class="nav-link active" href="input.php"
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
                        <h1 class="mt-4">Input Kasus Baru</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Input Kasus Baru</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                            <h1>Form Input Pasien</h1>
                                <form name="input" action="proses.php" method="POST">
                                <div class="form-group">
                                    <label for="preg">Jumlah Kehamilan</label>
                                    <input type="text" class="form-control col-sm-4" id="preg" name="preg" placeholder="Masukkan jumlah kehamilan 0 sampai 17">
                                </div>
                                <div class="form-group">
                                    <label for="glu">Gula Darah</label>
                                    <input type="text" class="form-control col-sm-4" id="glu" name="glu" placeholder="Masukkan kadar gula darah 0 sampai 199">
                                </div>
                                <div class="form-group">
                                    <label for="bp">Tekanan Darah</label>
                                    <input type="text" class="form-control col-sm-4" id="bp" name="bp" placeholder="Masukkan tekanan darah 0 sampai 122">
                                </div>
                                <div class="form-group">
                                    <label for="skin">Ketebalan Kulit</label>
                                    <input type="text" class="form-control col-sm-4" id="skin" name="skin" placeholder="Masukkan ketebalan kulit 0 sampai 99">
                                </div>
                                <div class="form-group">
                                    <label for="insulin">Kadar Insulin Dalam 2 Jam</label>
                                    <input type="text" class="form-control col-sm-4" id="insulin" name="insulin" placeholder="Masukkan kadar insulin 0 sampai 846">
                                </div>
                                <div class="form-group">
                                    <label for="bmi">BMI</label>
                                    <input type="text" class="form-control col-sm-4" id="bmi" name="bmi" placeholder="Masukkan BMI 0 sampai 67.1">
                                </div>
                                <div class="form-group">
                                    <label for="dpf">Kemungkinan Keturunan Diabetes</label>
                                    <input type="text" class="form-control col-sm-4" id="dpf" name="dpf" placeholder="Masukkan 0.078 sampai 2329">
                                </div>
                                <div class="form-group">
                                    <label for="age">Umur</label>
                                    <input type="text" class="form-control col-sm-4" id="age" name="age" placeholder="Masukkan umur 21 sampai 81">
                                </div>
                                <div class="form-group">
                                    <label for="nilai_k">Nilai K</label>
                                    <input type="text" class="form-control col-sm-4" id="nilai_k" name="nilai_k" placeholder="Masukkan jumlah k">
                                </div>
                                <input type="submit" class="btn btn-primary" name="input" value="Submit">
                                </form>
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
