<?php 
    include 'koneksi.php';
    function normalisasi($min, $max, $data){
        $hasil = ($data-$min)/($max-$min);
        $hasil_format = number_format($hasil,3);
        return $hasil_format;
    }

if(isset($_POST['preg'], $_POST['glu'], $_POST['bp'], $_POST['skin'], $_POST['insulin'], $_POST['bmi'], $_POST['dpf'], $_POST['age'], $_POST['nilai_k'])) {

    $preg = htmlspecialchars($_POST['preg']);
    $glu = htmlspecialchars($_POST['glu']);
    $bp = htmlspecialchars($_POST['bp']);
    $skin = htmlspecialchars($_POST['skin']);
    $insulin = htmlspecialchars($_POST['insulin']);
    $bmi = htmlspecialchars($_POST['bmi']);
    $dpf = htmlspecialchars($_POST['dpf']);
    $age = htmlspecialchars($_POST['age']);
    $k = htmlspecialchars($_POST['nilai_k']);

    

    $input_user = array($preg, $glu, $bp, $skin, $insulin, $bmi, $dpf, $age);
    $preg_norm = 0;
    $glu_norm = 0;
    $bp_norm = 0;
    $skin_norm = 0; 
    $insulin_norm = 0; 
    $bmi_norm = 0; 
    $dpf_norm = 0; 
    $age_norm = 0;

    // pengecekan tiap fitur untuk dinormalisasi
    for($x=0;$x<count($input_user);$x++){
        $konversi[$x] = floatval($input_user[$x]);
        if($x==0){
            $preg_norm = normalisasi(0,17,$konversi[0]);
        } elseif($x==1){
            $glu_norm = normalisasi(0,199,$konversi[1]);
        } elseif($x==2){
            $bp_norm = normalisasi(0,122,$konversi[2]);
        } elseif($x==3){
            $skin_norm = normalisasi(0,99,$konversi[3]);
        } elseif($x==4){
            $insulin_norm = normalisasi(0,846,$konversi[4]);
        } elseif($x==5){
            $bmi_norm = normalisasi(0,67.1,$konversi[5]);
        } elseif($x==6){
            $dpf_norm = normalisasi(0.078,2329,$konversi[6]);
        } elseif($x==7){
            $age_norm = normalisasi(21,81,$konversi[7]);
        }
        $temp = array($preg_norm, $glu_norm, $bp_norm, $skin_norm, $insulin_norm, $bmi_norm, $dpf_norm, $age_norm);
        $normal[$x] = floatval($temp[$x]);
    }
    echo"<br>";
    echo"<br>";
    echo"<br>";
    echo"<br>";
    echo"<br>";
    var_dump($normal);

    $sum = [];
    $jarak = [];
    $kelas = [];
    $urut = [];

    // query ambil basis kasus
    $query = mysqli_query($koneksi, "SELECT preg, glu, bp, skin, insulin, bmi, dpf, age FROM data_training");
    while($fitur = mysqli_fetch_array($query)){
        $sum_temp = 0;
        for($y=0;$y<8;$y++){
            $konversi[$y] = floatval($fitur[$y]);
            $kurang[$y] = ($konversi[$y]-$normal[$y])*($konversi[$y]-$normal[$y]);
            $sum_temp += $kurang[$y];
        }
        array_push($sum, $sum_temp);
    }
        // Hasil KNN
        $sqrt = 0;
        for($x=0;$x<count($sum);$x++){
            $sqrt = sqrt($sum[$x]);
            array_push($jarak, $sqrt);
    }

    // query ambil solusi basis kasus
    $query1 = mysqli_query($koneksi, "SELECT outcome FROM data_training");
    $out=0;
    while($data = mysqli_fetch_array($query1)){
        for($x=0;$x<1;$x++){
            $out = $data[$x];
        }
        
        array_push($kelas, $out);
    }

    // Sorting Hasil KNN
    for($i=0; $i < count($jarak)-1 ; $i++){
        for($j=$i+1;$j<count($jarak); $j++){
            if($jarak[$i] > $jarak[$j]){
                $temp 		= $jarak[$i];
                $jarak[$i] 	= $jarak[$j];
                $jarak[$j] = $temp;

                $temp 		= $kelas[$i];
                $kelas[$i] 	= $kelas[$j];
                $kelas[$j] = $temp;
            }
        }
    }
    $nilai_k = intval($k);

    $diagnosis = [];
    $input = 0;
    for($i=0;$i<$nilai_k;$i++){
        $input = $kelas[$i];
        array_push($diagnosis, $input);
    }
    $diabetes = 0;
    $tidak_diabetes = 0;
    for($i=0;$i<$nilai_k;$i++){
        if($diagnosis[$i] == 1){
            $diabetes +=1;
        } elseif($diagnosis[$i] == 0){
            $tidak_diabetes +=1;
        }

        if($diabetes > $tidak_diabetes){
            $output = 1;
        } elseif($diabetes < $tidak_diabetes){
            $output = 0;
        }
    }

    // input data kasus baru ke tabel kasus baru
    $insert = "INSERT INTO kasus_baru VALUES ('', '$preg', '$glu', '$bp', '$skin', '$insulin', '$bmi', '$dpf', '$age', '$output')";
    $exe = mysqli_query($koneksi, $insert);

    if (!$exe) {
        die('Query Error : ' . mysqli_errno($koneksi) . '-' . mysqli_error($koneksi));
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
                            <a class="nav-link active" href="proses.php"
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
                        <h1 class="mt-4">Tabel Hasil Perhitungan KNN</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Hasil Diagnosis</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header"><i class="fas fa-table mr-1"></i>Hasil Perhitungan KNN</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <?php  if(isset($output)) {?>
                                <div class="alert alert-success" role="alert">
                                    <h5>
                                    Hasil Diagnosis Untuk Kasus Baru : 
                                    <?php if($output == 1){ 
                                        echo "Penderita Penyakit Diabetes"; 
                                    } elseif($output == 0){ 
                                        echo "Bukan Penderita Penyakit Diabetes";
                                        } ?>
                                    </h5>
                                </div>
                                    <?php } ?>
                                
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jarak Kasus Baru Dengan Basis Kasus</th>
                                                <th>Hasil Diagnosis</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(isset($kelas, $nilai_k, $jarak)) {
                                            for($x=0;$x<count($kelas);$x++){?>
                                            <tr <?= $x<=$nilai_k-1 ? "style='background-color: whitesmoke'" :  "style='background-color: white'"; ?>>
                                                <td><?= $x+1; ?></td>
                                                <td><?= $jarak[$x]; ?></td>
                                                <td>
                                                    <?php if($kelas[$x] == 1) { 
                                                        echo "Penderita Penyakit Diabetes";
                                                    } elseif($kelas[$x] == 0) {
                                                        echo "Bukan Penderita Penyakit Diabetes";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php }
                                            } ?>
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