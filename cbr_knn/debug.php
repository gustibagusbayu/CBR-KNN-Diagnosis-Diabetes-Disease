<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Hasil CBR</title>
</head>
<body>
    <?php 
    include 'koneksi.php';
        function normalisasi($min, $max, $data){
            $hasil = ($data-$min)/($max-$min);
            $hasil_format = number_format($hasil,3);
            return $hasil_format;
        }

        $preg = htmlspecialchars($_POST['preg']);
        $glu = htmlspecialchars($_POST['glu']);
        $bp = htmlspecialchars($_POST['bp']);
        $skin = htmlspecialchars($_POST['skin']);
        $insulin = htmlspecialchars($_POST['insulin']);
        $bmi = htmlspecialchars($_POST['bmi']);
        $dpf = htmlspecialchars($_POST['dpf']);
        $age = htmlspecialchars($_POST['age']);
        $nilai_k = htmlspecialchars($_POST['nilai_k']);

        $insert = "INSERT INTO kasus_baru VALUES ('', '$preg', '$glu', '$bp', '$skin', '$insulin', '$bmi', '$dpf', '$age', '0')";
        $exe = mysqli_query($koneksi, $insert);

        if (!$exe) {
            die('Query Error : ' . mysqli_errno($koneksi) . '-' . mysqli_error($koneksi));
        } 
    
        $input_user = array($preg, $glu, $bp, $skin, $insulin, $bmi, $dpf, $age);
        var_dump($input_user);
        for($x=0;$x<count($input_user);$x++){
            $konversi[$x] = floatval($input_user[$x]);
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

            $temp = array($preg, $glu, $bp, $skin, $insulin, $bmi, $dpf, $age);
            $normal[$x] = floatval($temp[$x]);
        }
        // var_dump($konversi);
        var_dump($normal);

        // $bobot = array(0.471,0.924,0.525,0,0,0.347,0,0.183,1);
        
        $sum = [];
        $jarak = [];
        $kelas = [];
        $urut = [];
        // $sum = array(0,0,0);
        $query = mysqli_query($koneksi, "SELECT preg, glu, bp, skin, insulin, bmi, dpf, age, outcome FROM data_training");
                while($hasil = mysqli_fetch_array($query)){
                    $sum_temp = 0;
                    for($y=0;$y<8;$y++){
                        $konversi[$y] = floatval($hasil[$y]);
                        $hasil1[$y] = ($konversi[$y]-$normal[$y])*($konversi[$y]-$normal[$y]);
                        // echo $konversi[$y]. "=hasil  - bobot=" .$normal[$y];
                        // echo "<br>";
                        // echo "Hasil data kolom ke-$y = " . $hasil1[$y];
                        // echo "<br>";
                        $sum_temp += $hasil1[$y];

                    }
                    
                    array_push($sum, $sum_temp);
                    }
                    $sqrt = 0;
                for($x=0;$x<count($sum);$x++){
                    // echo "Data baris ke-$x = " . $sum[$x];
                    $sqrt = sqrt($sum[$x]);
                    // echo "<br>";
                    // echo "<br>";
                    array_push($jarak, $sqrt);
                }

                $query1 = mysqli_query($koneksi, "SELECT outcome FROM data_training");
                $out=0;
                while($hasil2 = mysqli_fetch_array($query1)){
                    for($x=0;$x<1;$x++){
                        $out = $hasil2[$x];
                    }
                    
                    array_push($kelas, $out);
                }

                // Hasil KNN
                // sort($jarak);
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
                for($x=0;$x<count($jarak);$x++){
                    echo "Data yang diakarkan baris ke-$x = " . $jarak[$x];
                    echo "<br>";
                    echo "<br>";
                }


            
            // Kelas Tiap Baris Data
            for($x=0;$x<count($kelas);$x++){
                echo "Kelas ke-$x = " . $kelas[$x];
                echo "<br>";
                echo "<br>";
            }

                echo "<br>";
        

        // echo normalisasi(2,5,4);
            
        
        
        

        // for($x=0;$x<2;$x++){//baris bobot
		// 	for($y=0;$y<25;$y++){// kolom huruf & bobot
		// 		$pangkat[$x][$y]=($huruf[$a][$y]-$bobot[$x][$y])*($huruf[$a][$y]-$bobot[$x][$y]);
		// 		// echo "bobot = " . $bobot[$x][$y];
		// 		echo "pangkat = " . $pangkat[$x][$y];
		// 		echo "<br>";
				
		// 		}
				
		// 	for($y=0;$y<25;$y++){
		// 		$sum[$x]=$sum[$x]+$pangkat[$x][$y];	
		// 		echo "sum = " . $sum[$x];
		// 	//hitung euclidian distance
		// 	$sqrt[$x]=sqrt($sum[$x]);//nilai d (jarak)
        //     }
        // }
    
    ?>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</html>