
<footer class="footer">
  <div class="container-fluid d-flex justify-content-between">
    <nav class="pull-left">
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link" href="http://www.themekita.com">
            ThemeKita
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"> Help </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"> Licenses </a>
        </li>
      </ul>
    </nav>
    <div class="copyright">
      2024, made with <i class="fa fa-heart heart text-danger"></i> by
      <a href="http://www.themekita.com">ThemeKita</a>
    </div>
    <div>
      Distributed by
      <a target="_blank" href="https://themewagon.com/">ThemeWagon</a>.
    </div>
  </div>
</footer>
</div>


<script src="<?php echo base_url(); ?>dist/js/core/jquery-3.7.1.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/core/popper.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/core/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/chart.js/chart.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/chart-circle/circles.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/datatables/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/jsvectormap/jsvectormap.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/jsvectormap/world.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/sweetalert/sweetalert.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/kaiadmin.min.js"></script>
<script>
  var myModal = document.getElementById('myModal')
  var myInput = document.getElementById('myInput')

  myModal.addEventListener('shown.bs.modal', function () {
    myInput.focus()
  })
  $("#basic-datatables").DataTable({});

  var pieChart = document.getElementById("pieChart").getContext("2d");

  var myPieChart = new Chart(pieChart, {
    type: "pie",
    data: {
      datasets: [
        {
          data: [50, 35, 15],
          backgroundColor: ["#1d7af3", "#f3545d", "#fdaf4b"],
          borderWidth: 0,
        },
      ],
      labels: ["Pendapatan", "Pengeluaran", "Hpp"],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        position: "bottom",
        labels: {
          fontColor: "rgb(154, 154, 154)",
          fontSize: 11,
          usePointStyle: true,
          padding: 20,
        },
      },
      pieceLabel: {
        render: "percentage",
        fontColor: "white",
        fontSize: 14,
      },
      tooltips: false,
      layout: {
        padding: {
          left: 20,
          right: 20,
          top: 20,
          bottom: 20,
        },
      },
    },
  });
</script>
</body>
</html>