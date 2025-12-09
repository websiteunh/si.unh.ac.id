

    <div class="row">      
      <body onload="statusBrowser();statusOs();grafikArtikel();">
        <div class="col-md-12 col-lg-12 grid-margin" >
          <div class="card">
            
            <div class="card-body">
              <h4 class="card-title">Grafik Website Engagement </h4>
              <div class="grafik_web" style="width:100%; height:400px;"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Presentase Browser yang Akses Website </h4>
              <div id="grafik_browser"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Presentase OS yang Akses Website </h4>
              <div id="grafik_os"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Presentase Artikel Paling Banyak Dibaca </h4>
              <div id="grafikArtikel"></div>
            </div>
          </div>      
        </div>

        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Jumlah Artikel Publish </h4>
              <div id="publishArtikel"></div>
            </div>
          </div>      
        </div>
      
    </div>
  </div>  
  <base href="<?php echo base_url(); ?>" />
  
  <script src="assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
  <script src="assets/js/highcharts.js" type="text/javascript"></script>
  <script src="assets/js/exporting.js" type="text/javascript"></script>
  <script src="assets/js/series-label.js" type="text/javascript"></script>
  <script src="assets/js/export-data.js" type="text/javascript"></script>
<script type="text/javascript">
$('.grafik_web').highcharts({
  <?php   
  $tgl_akhir2 = date("Y-m-d");   
  $tgl_awal2 = manipulate_time($tgl_akhir2,"days",30,"-","Y-m-d");  
  $cari_data = $this->db->query("SELECT date,10 AS tgl, sum(hits) AS jum FROM md_visitor WHERE date
    BETWEEN '$tgl_awal2' AND '$tgl_akhir2' GROUP BY date
    ORDER BY tgl ASC");
  ?>
  chart: {
    type: 'line',
    marginTop: 80
  },
  credits: {
    enabled: false
  }, 
  tooltip: {
    shared: true,
    crosshairs: true,
    headerFormat: '<b>{point.key}</b>< br />'
  },
  title: {
    text: 'Jumlah Akses User 2 Bulan Terakhir'
  },
  subtitle: {
    text: ""
  },
  xAxis: {
    categories: [
    <?php 
    foreach($cari_data->result() AS $label){
      $tgl_b = substr($label->tgl, 5, 5);
      echo "'$tgl_b'";
      echo ",";
    }
    ?>
    ],
    labels: {
      rotation: 0,
      align: 'right',
      style: {
        fontSize: '10px',
        fontFamily: 'Verdana, sans-serif'
      }
    }
  },
  legend: {
    enabled: true
  },
  series: [{
    "name":"Pengguna",
    "data":[

    <?php 
    foreach($cari_data->result() AS $label){      
      echo "$label->jum";
      echo ",";
    }
    ?>

    ]
    }]
});
</script>
<script type="text/javascript">
function statusBrowser(){
    var chart = new Highcharts.Chart({

    chart: {
        renderTo: 'grafik_browser',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    credits: {
            enabled: false
          },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Status',
        colorByPoint: true,
        data: [

        <?php         
        $sql = $this->db->query("SELECT browser,sum(hits) AS jum FROM md_visitor GROUP BY browser ORDER BY browser ASC");
        foreach($sql->result() AS $isi){          
          $tt = $this->db->query("SELECT sum(hits) AS jum FROM md_visitor")->row();
          $y = ($isi->jum / $tt->jum) * 100;
          $r = round($y,2);
          $status = $isi->browser;           
          echo "{ y : $r, name: '$status ($isi->jum)'},";        
        }
        ?>

       ]
    }]
  });
}
</script>
<script type="text/javascript">
function statusOs(){
    var chart = new Highcharts.Chart({

    chart: {
        renderTo: 'grafik_os',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    credits: {
            enabled: false
          },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Status',
        colorByPoint: true,
        data: [

        <?php         
        $sql = $this->db->query("SELECT os,sum(hits) AS jum FROM md_visitor GROUP BY os ORDER BY browser ASC");
        foreach($sql->result() AS $isi){          
          $tt = $this->db->query("SELECT sum(hits) AS jum FROM md_visitor")->row();
          $y = ($isi->jum / $tt->jum) * 100;
          $r = round($y,2);
          $status = $isi->os;           
          echo "{ y : $r, name: '$status ($isi->jum)'},";        
        }
        ?>

       ]
    }]
  });
}

$(document).ready(function() {
    var chart1; // globally available
    $(document).ready(function() {
      chart1 = new Highcharts.Chart({
       chart: {
        renderTo: 'publishArtikel',
        type: 'column'
      },   
      title: {
        text: 'Jumlah Publish'
      },
      xAxis: {
        categories: ['Jumlah Artikel']
      },
      yAxis: {
        title: {
         text: ''
       }
     },
     series:             
     [
     <?php          
    $sql   = "SELECT COUNT(md_artikel.id_artikel) AS jum, md_user.nama_lengkap FROM md_artikel      
      INNER JOIN md_user ON md_artikel.created_by = md_user.id_user
      WHERE md_artikel.status = 'publish'
      GROUP BY md_artikel.created_by ORDER BY md_artikel.created_by DESC";
    
    $cek = $this->db->query($sql);
    foreach ($cek->result() as $r) {          
      $judul=$r->nama_lengkap;                    
      $jum=$r->jum;            
      ?>
      {
        name: '<?php echo $judul; ?>',
        data: [<?php echo $jum; ?>]
      },
    <?php } ?>
    ]
  });
    }); 
  });
  $(document).ready(function() {
    var chart1; // globally available
    $(document).ready(function() {
      chart1 = new Highcharts.Chart({
       chart: {
        renderTo: 'grafikArtikel',
        type: 'column'
      },   
      title: {
        text: 'Jumlah Akses'
      },
      xAxis: {
        categories: ['Judul Artikel']
      },
      yAxis: {
        title: {
         text: ''
       }
     },
     series:             
     [
     <?php          
    $sql   = "SELECT md_artikel.judul, md_artikel.baca AS jum FROM md_artikel      
      WHERE baca > 0 AND status='publish'
      GROUP BY md_artikel.judul ORDER BY jum DESC LIMIT 0,15";
    
    $cek = $this->db->query($sql);
    foreach ($cek->result() as $r) {          
      $judul=substr($r->judul,0,10);                    
      $jum=$r->jum;            
      ?>
      {
        name: '<?php echo $judul; ?>',
        data: [<?php echo $jum; ?>]
      },
    <?php } ?>
    ]
  });
    }); 
  });
</script>
  
</body>
</html>