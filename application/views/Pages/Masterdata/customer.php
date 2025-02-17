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
                <h3 class="fw-bold mb-3">Daftar Customer</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-info"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button>
                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-6 border-right">
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Kode Customer</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="inlineinput" value="Auto">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Nama Customer</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="inlineinput" placeholder="Nama Customer">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Tgl. Lahir</label>
                              <div class="col-md-12 p-0">
                                <input type="date" class="form-control input-full" id="inlineinput" >
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Jenis Kelamin</label>
                              <div class="col-md-12 p-0">
                                <select class="form-select form-control" id="defaultSelect">
                                  <option value="L">Laki - Laki</option>
                                  <option value="P">Perempuan</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Alamat</label>
                              <div class="col-md-12 p-0">
                                <textarea class="form-control" id="comment" rows="4"></textarea>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Blok & No Rumah</label>
                              <div class="row" style="padding-left: 15px;">
                                <div class="col-md-5 p-0" style="margin-right:15px;">
                                  <input type="text" class="form-control input-full" id="inlineinput" placeholder="Blok">
                                </div>
                                <div class="col-md-5 p-0">
                                  <input type="text" class="form-control input-full" id="inlineinput" placeholder="No">
                                </div>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">RT/RW</label>
                              <div class="row" style="padding-left: 15px;">
                                <div class="col-md-5 p-0" style="margin-right:15px;">
                                  <input type="text" class="form-control input-full" id="RT" placeholder="RT">
                                </div>
                                <div class="col-md-5 p-0">
                                  <input type="text" class="form-control input-full" id="RW" placeholder="RW">
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">No Telp</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="inlineinput" placeholder="No Telp">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Email</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="inlineinput" placeholder="Email">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Alamat Pengiriman</label>
                              <div class="col-md-12 p-0">
                                <textarea class="form-control" id="comment" rows="4"></textarea>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">NPWP</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="inlineinput" placeholder="NPWP">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">NIK</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="inlineinput" placeholder="NIK">
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>
                      
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
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
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>Telp</th>
                  <th>Poin</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>C122400001</td>
                  <td>ABAN DONI</td>
                  <td>JALAN ADISUCIPTO KM 8 DESA PARIT BARU RT.003 RW.006 SUNGAI RAYA, SUNGAI RAYA KAB. KUBU RAYA KALIMANTAN BARAT</td>
                  <td>0800000000</td>
                  <td>0</td>
                  <td>
                    <a href="iframe.html" data-fancybox data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn"><i class="fas fa-eye sizing-fa"></i></button></a>
                    <button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" ><i class="fas fa-trash-alt sizing-fa"></i></button>
                    <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn"><i class="far fa-edit sizing-fa"></i></button>
                  </td>
                </tr>
                <tr>
                  <td>C102300002</td>
                  <td>Beni</td>
                  <td>KOMP PERMATA PURNAMA NO A-19</td>
                  <td>0852323123</td>
                  <td>0</td>
                  <td>
                      <a href="iframe.html" data-fancybox data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn"><i class="fas fa-eye sizing-fa"></i></button></a>
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
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      type: "warning",
      buttons: {
        cancel: {
          visible: true,
          text: "No, cancel!",
          className: "btn btn-danger",
        },
        confirm: {
          text: "Yes, delete it!",
          className: "btn btn-success",
        },
      },
    }).then((willDelete) => {
      if (willDelete) {
        swal("Poof! Your imaginary file has been deleted!", {
          icon: "success",
          buttons: {
            confirm: {
              className: "btn btn-success",
            },
          },
        });
      } else {
        swal("Your imaginary file is safe!", {
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