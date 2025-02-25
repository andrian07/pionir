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
                <div class="btn-group dropdown">
                  <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"><span class="btn-label"><i class="fas fa-file-excel"></i></span> Excell</button>
                  <ul class="dropdown-menu" role="menu">
                    <li>
                      <a class="dropdown-item" href="#">Download Template</a>
                      <a class="dropdown-item" href="#">Import Excell</a>
                    </li>
                  </ul>
                </div>
                <button class="btn btn-info"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button>
                <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
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
                                <input type="text" class="form-control input-full" id="customer_code" value="Auto" readonly>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Nama Customer</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="customer_name" placeholder="Nama Customer">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Tgl. Lahir</label>
                              <div class="col-md-12 p-0">
                                <input type="date" class="form-control input-full" id="customer_dob" >
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Jenis Kelamin</label>
                              <div class="col-md-12 p-0">
                                <select class="form-select form-control" id="customer_gender">
                                  <option value="L">Laki - Laki</option>
                                  <option value="P">Perempuan</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Alamat</label>
                              <div class="col-md-12 p-0">
                                <textarea class="form-control" id="customer_address" rows="4"></textarea>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Blok & No Rumah</label>
                              <div class="row" style="padding-left: 15px;">
                                <div class="col-md-5 p-0" style="margin-right:15px;">
                                  <input type="text" class="form-control input-full" id="customer_address_block" placeholder="Blok">
                                </div>
                                <div class="col-md-5 p-0">
                                  <input type="text" class="form-control input-full" id="customer_address_no" placeholder="No">
                                </div>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">RT/RW</label>
                              <div class="row" style="padding-left: 15px;">
                                <div class="col-md-5 p-0" style="margin-right:15px;">
                                  <input type="text" class="form-control input-full" id="customer_address_rt" placeholder="RT">
                                </div>
                                <div class="col-md-5 p-0">
                                  <input type="text" class="form-control input-full" id="customer_address_rw" placeholder="RW">
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">No Telp</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="customer_address_phone" placeholder="No Telp">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Email</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="customer_address_email" placeholder="Email">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Alamat Pengiriman</label>
                              <div class="col-md-12 p-0">
                                <textarea class="form-control" id="customer_address_delivery" rows="4"></textarea>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Expedisi</label>
                              <div class="col-md-12 p-0">
                                <select class=" form-control input-full js-example-basic-multiple js-states" name="customer_expedisi" id="customer_expedisi" multiple="multiple">
                                  <option value="PJ">Prima Jasa</option>
                                  <option value="LP">Lion Parcel</option>
                                  <option value="JNE">JNE</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">NPWP</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="customer_npwp" placeholder="NPWP">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">NIK</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="customer_nik" placeholder="NIK">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Rate Customer</label>
                              <div class="col-md-12 p-0">
                                <select class="form-select form-control" id="customer_group_price">
                                  <option value="Normal">Normal</option>
                                  <option value="Toko">Toko</option>
                                  <option value="Sales">Sales</option>
                                  <option value="Khusus">Khusus</option>
                                </select>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>


                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
                        <button type="button" id="btnsave" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
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
                  <th>Rate</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>Telp</th>
                  <th>Expedisi</th>
                  <th>Poin</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($customer_list as $row){ ?>
                  <tr>
                    <td><?php echo $row->customer_code; ?></td>
                    <td><span class="badge badge-primary"><?php echo $row->customer_rate; ?></span></td>
                    <td><?php echo $row->customer_name; ?></td>
                    <td><?php echo $row->customer_address; ?></td>
                    <td><?php echo $row->customer_phone; ?></td>
                    <td><span class="badge badge-primary multi-badge">JNE</span><span class="badge badge-primary multi-badge">Lion Parcel</span></td>
                    <td><?php echo $row->customer_poin; ?></td>
                    <td>
                      <a href="<?php echo base_url();?>Masterdata/detailcustomer" data-fancybox data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn"><i class="fas fa-eye sizing-fa"></i></button></a>
                      <button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" ><i class="fas fa-trash-alt sizing-fa"></i></button>
                      <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn"><i class="far fa-edit sizing-fa"></i></button>
                    </td>
                  </tr>
                <?php } ?>
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


  $('#btnsave').click(function(e){
    e.preventDefault();
    var customer_name           = $("#customer_name").val();
    var customer_dob            = $("#customer_dob").val();
    var customer_gender         = $("#customer_gender").val();
    var customer_address        = $("#customer_address").val();
    var customer_address_block  = $("#customer_address_block").val();
    var customer_address_no     = $("#customer_address_no").val();
    var customer_address_rt     = $("#customer_address_rt").val();
    var customer_address_rw     = $("#customer_address_rw").val();
    var customer_address_phone  = $("#customer_address_phone").val();
    var customer_address_email  = $("#customer_address_email").val();
    var customer_dob            = $("#customer_dob").val();
    var customer_gender         = $("#customer_gender").val();
    var customer_expedisi       = $("#customer_expedisi").val();
    var customer_npwp           = $("#customer_npwp").val();
    var customer_nik            = $("#customer_nik").val();
    var customer_group_price    = $("#customer_group_price").val();


    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/save_customer",
      dataType: "json",
      data: {customer_name:customer_name, customer_dob:customer_dob, customer_gender:customer_gender, customer_address:customer_address, customer_address_block:customer_address_block, customer_address_no:customer_address_no, customer_address_rt:customer_address_rt, customer_address_rw:customer_address_rw, customer_address_phone:customer_address_phone, customer_address_email:customer_address_email, customer_dob:customer_dob, customer_gender:customer_gender, customer_expedisi:customer_expedisi, customer_npwp:customer_npwp, customer_nik:customer_nik, customer_group_price:customer_group_price},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>Masterdata/customer";
          Swal.fire('Saved!', '', 'success');
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: data.result,
          })
        }
      }
    });
  });
</script>