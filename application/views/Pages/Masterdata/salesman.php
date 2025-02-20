<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
</div>

<div class="container">
  <div class="page-inner">
    <div class="page-header">

    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-left">
              <div>
                <h3 class="fw-bold mb-3">Daftar Salesman</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-info"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button>
                <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Salesman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <div class="modal-body">
                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Kode Salesman</label>
                          <div class="col-md-12 p-0">
                            <input type="text" class="form-control input-full" id="salesman_code" value="Auto">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Nama Salesman</label>
                          <div class="col-md-12 p-0">
                            <input type="text" class="form-control input-full" id="salesman_name" placeholder="Nama Salesman">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Telp</label>
                          <div class="col-md-12 p-0">
                            <input type="text" class="form-control input-full" id="salesman_telp" placeholder="Telp Salesman">
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Alamat</label>
                          <div class="col-md-12 p-0">
                            <textarea class="form-control" id="salesman_address" rows="5"></textarea>
                          </div>
                        </div>

                        <div class="form-group form-inline">
                          <label for="inlineinput" class="col-md-3 col-form-label">Cabang</label>
                          <div class="col-md-12 p-0">
                            <select class="form-select form-control" id="salesman_branch">
                              <option value="SDM">Serdam</option>
                              <option value="KBR">Kota Baru</option>
                              <option value="PST">Pusat</option>
                            </select>
                          </div>
                        </div>

                      </div>

                      
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
                        <button type="button" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table
              id="basic-datatables"
              class="display table table-striped table-hover"
              >
              <thead>
                <tr>
                  <th>Kode Salesman</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>Telp</th>
                  <th>Cabang</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>S0001</td>
                  <td>Beni</td>
                  <td>JALAN ADISUCIPTO KM 8 DESA PARIT BARU RT.003 RW.006 SUNGAI RAYA, SUNGAI RAYA KAB. KUBU RAYA KALIMANTAN BARAT</td>
                  <td>0800000000</td>
                  <td>Serdam</td>
                  <td>
                    <a href="<?php echo base_url();?>Masterdata/detailsalesman" data-fancybox data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn"><i class="fas fa-eye sizing-fa"></i></button></a>
                    <button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" ><i class="fas fa-trash-alt sizing-fa"></i></button>
                    <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn"><i class="far fa-edit sizing-fa"></i></button>
                  </td>
                </tr>
                <tr>
                  <td>S0002</td>
                  <td>Rudi</td>
                  <td>JALAN ADISUCIPTO KM 8 DESA PARIT BARU RT.003 RW.006 SUNGAI RAYA, SUNGAI RAYA KAB. KUBU RAYA KALIMANTAN BARAT</td>
                  <td>0800000000</td>
                  <td>Pusat</td>
                  <td>
                    <a href="<?php echo base_url();?>Masterdata/detailsalesman" data-fancybox data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn"><i class="fas fa-eye sizing-fa"></i></button></a>
                    <button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" ><i class="fas fa-trash-alt sizing-fa"></i></button>
                    <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn"><i class="far fa-edit sizing-fa"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
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
</script>