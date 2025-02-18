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
                <h3 class="fw-bold mb-3">Pengaturan Satuan & Harga Produk</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
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
                                <input type="text" class="form-control input-full" id="customer_code" value="Auto">
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
                                <select class=" form-control input-full js-example-basic-multiple js-states" name="states[]" id="customer_expedisi" multiple="multiple">
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
            <table width="100%" class="mb-3">
              <tbody>
                <tr>
                  <th width="15%">Kode Produk</th>
                  <td width="1%">:</td>
                  <td width="84%" id="setup_product_code">00020018</td>
                </tr>
                <tr>
                  <th>Nama Produk</th>
                  <td>:</td>
                  <td id="setup_product_name">Spk ACR 15" 15600 Black TES 1 2 3</td>
                </tr>
                <tr>
                  <th>Satuan Dasar</th>
                  <td>:</td>
                  <td id="setup_base_unit">1/2 DAM</td>
                </tr>
              </tbody>
            </table>

            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col" rowspan="2">Aksi</th>
                    <th scope="col" rowspan="2">Barcode</th>
                    <th scope="col" rowspan="2">Satuan</th>
                    <th scope="col" rowspan="2">Isi</th>
                    <th scope="col" rowspan="2">DPP</th>
                    <th scope="col" rowspan="2">PPN</th>
                    <th scope="col" rowspan="2">Harga Beli</th>
                    <th scope="col" colspan="2" style="text-align:center;">Normal</th>
                    <th scope="col" colspan="2" style="text-align:center;">Toko</th>
                    <th scope="col" colspan="2" style="text-align:center;">Sales</th>
                    <th scope="col" colspan="2" style="text-align:center;">Khusus</th>
                  </tr>
                  <tr>
                    <td scope="col">Margin</td>
                    <td scope="col">Hrg.Jual</td>
                    <td scope="col">Margin</td>
                    <td scope="col">Hrg.Jual</td>
                    <td scope="col">Margin</td>
                    <td scope="col">Hrg.Jual</td>
                    <td scope="col">Margin</td>
                    <td scope="col">Hrg.Jual</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn"><i class="far fa-edit sizing-fa"></i></button>
                    </td>
                    <td>00020018</td>
                    <td>1/2 DAM</td>
                    <td>1</td>
                    <td>200.000</td>
                    <td>22.000</td>
                    <td>220.000</td>
                    <td>20%</td>
                    <td>266.400</td>
                    <td>20%</td>
                    <td>266.400</td>
                    <td>20%</td>
                    <td>266.400</td>
                    <td>20%</td>
                    <td>266.400</td>
                  </tr>
                  <tr>
                    <td colspan="15">
                      <a href="#" id="btnadd_item"><i class="fas fa-plus"></i> Tambahkan</a>
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

  $('body').on('shown.bs.modal', '.modal', function() {
    $(this).find('.js-example-basic-multiple').each(function() {
      var dropdownParent = $(document.body);
      if ($(this).parents('#myModal').length !== 0)
        dropdownParent = $("#myModal");
      $(this).select2({
        dropdownParent: $("#myModal")
      // ...
    });
    });
  });

  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
  });

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