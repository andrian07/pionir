<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
</div>

<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3" style="padding-left: 20px;">Informasi Produk</h3>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div id="info" class="col-12"></div>

              <div class="col-12">
                <label style="font-weight: 700; margin-bottom: 5px; margin-left:5px;">Barcode / Nama Produk</label>
              </div>
              <div class="col-sm-10">
                <!-- text input -->
                <div class="form-group">
                  <input id="myInput" name="search" type="text" onkeyup="searchproduct()" class="form-control ui-autocomplete-input" placeholder="Barcode atau Nama Produk" value="" autocomplete="off">
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="SearchTable" class="table table-hover">
                <tbody>
                  <tr onclick="popupOpen(1)">
                    <td>Sudut Box Spk <br /> <span class="badge badge-success">Rp. 5.000</span></td>
                    <td>50 Pcs</td>
                  </tr>
                  <tr onclick="popupOpen(2)">
                    <td>FBT JF0501 <br /> <span class="badge badge-success">Rp. 25.000</span></td>
                    <td>60 Pcs</td>
                  </tr>
                  <tr onclick="popupOpen(3)">
                    <td>Tr MD2000 <br /> <span class="badge badge-success">Rp. 165.000</span></td>
                    <td>20 Box</td>
                  </tr>
                  <tr onclick="popupOpen(4)">
                    <td>Tr MD2031FX <br /> <span class="badge badge-success">Rp. 51.000</span></td>
                    <td>11 Box</td>
                  </tr>
                  <tr onclick="popupOpen(5)">
                    <td>TR ST2001 <br /> <span class="badge badge-success">Rp. 35.000</span></td>
                    <td>7 Meter</td>
                  </tr>
                  <tr onclick="popupOpen(6)">
                    <td>zzzz FBT DTS2010-D91 <br /> <span class="badge badge-success">Rp. 45.000</span></td>
                    <td>2 Bal</td>
                  </tr>
                </tbody>
              </table>

              <div id="dialog-content" style="display:none;max-width:500px;">
                <h2>Hello, world!</h2>
                <p>
                  <input type="text" value="" />
                </p>
                <p>
                  Try hitting the tab key and notice how the focus stays within the dialog
                  itself.
                </p>
                <p>
                  To close dialog hit the esc button, click on the overlay or just click the
                  close button.
                </p>
                <p>
                  Element used to launch the modal would receive focus back after closing.
                </p>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php 
require DOC_ROOT_PATH . $this->config->item('footer');
?>

<script>

  $(".delete").click(function (e) {
    swal({
      title: "Hapus !!",
      text: "Hapus Data!",
      type: "warning",
      buttons: {
        cancel: {
          visible: true,
          text: "Tidak, Batal!",
          className: "btn btn-danger",
        },
        confirm: {
          text: "Ya, Hapus!",
          className: "btn btn-success",
        },
      },
    }).then((willDelete) => {
      if (willDelete) {
        swal("Sukses Hapus Data!", {
          icon: "success",
          buttons: {
            confirm: {
              className: "btn btn-success",
            },
          },
        });
      }
    });
  });

  function searchproduct() {


  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("SearchTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    td1 = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      txtValue2 = td1.textContent || td1.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function popupOpen(id) {
  let link = window.location.origin + window.location.pathname + '/detailsearch';
  console.log(link);
  Fancybox.show([
  {
    src: link,
    type: "iframe",
    preload: false,
    top:0,
  },
  ]);
}

</script>