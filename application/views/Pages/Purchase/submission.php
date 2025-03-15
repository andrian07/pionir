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
                <h3 class="fw-bold mb-3">Daftar Pengajuan</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-info"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button>
                <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Supplier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>


                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-6 border-right border-primary">
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">No Invoice</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="submission_invoice" value="Auto">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Tanggal</label>
                              <div class="col-md-12 p-0">
                                <input type="date" class="form-control input-full" id="submission_date" value="<?php echo date("Y-m-d"); ?>" readonly>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Gudang</label>
                              <div class="col-md-12 p-0">
                                <select class="form-control input-full js-example-basic-single" id="submission_warehouse" name="submission_warehouse">
                                  <option>-- Pilih Gudang --</option>
                                  <?php foreach ($data['warehouse_list'] as $row) { ?>
                                    <option value="<?php echo $row->warehouse_id; ?>"><?php echo $row->warehouse_name; ?></option>  
                                  <?php } ?>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Sales</label>
                              <div class="col-md-12 p-0">
                                <select class="form-control input-full js-example-basic-single" id="submission_salesman" name="submission_salesman">
                                  <option>-- Pilih Sales --</option>
                                  <?php foreach ($data['salesman_list'] as $row) { ?>
                                    <option value="<?php echo $row->salesman_id; ?>"><?php echo $row->salesman_name; ?></option>  
                                  <?php } ?>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Keterangan</label>
                              <div class="col-md-12 p-0">
                                <textarea class="form-control" id="submission_desc" rows="5"></textarea>
                              </div>
                            </div>

                          </div>

                          <div class="col-md-6">
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Status</label>
                              <div class="col-md-12 p-0">
                               <select class="form-control input-full js-example-basic-single" id="submission_status" name="submission_status">
                                <option>-- Pilih Status --</option>
                                <option value="Urgent">Urgent</option>
                                <option value="New">New</option> 
                                <option value="Restock">Restock</option> 
                              </select>
                            </div>
                          </div>

                          <div class="form-group form-inline">
                            <label for="inlineinput" class="col-md-3 col-form-label">Kode Produk</label>
                            <div class="col-md-12 p-0">
                              <input type="text" class="form-control input-full" id="submission_product_code" readonly>
                            </div>
                          </div>

                          <div class="form-group form-inline">
                            <label for="inlineinput" class="col-md-3 col-form-label">Produk</label>
                            <div class="col-md-12 p-0">
                              <input type="hidden" id="submission_product_id" name="submission_product_id" class="form-control text-right" required="">
                              <input id="submission_product_name" name="submission_product_name" type="text" class="form-control input-full ui-autocomplete-input" placeholder="ketikkan nama produk">
                            </div>
                          </div>

                          <div class="form-group form-inline">
                            <label for="inlineinput" class="col-md-3 col-form-label">Qty</label>
                            <div class="col-md-12 p-0">
                              <input type="text" class="form-control input-full" id="submission_qty">
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
                <th>Nama Item</th>
                <th>No Pengajuan</th>
                <th>Tgl. Pengajuan</th>
                <th>Status</th>
                <th>Catatan</th>
                <th>Diajukan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>00020016 - Spk ACR 12" 1225 NEW Fullrange(PCS)</td>
                <td>PJ/K/25/01/24/0000000042  </td>
                <td>24/01/2025</td>
                <td><span class="badge badge-primary">Pending</span></td>
                <td>Admin</td>
                <td>
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

  $(document ).ready(function() {
    $('#product-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      ajax: {
        url: '<?php echo base_url(); ?>Masterdata/product_list',
        type: 'POST',
        data:  {},
      },
      columns: 
      [
        {data: 0},
        {data: 1},
        {data: 2},
        {data: 3},
        {data: 4},
        {data: 5},
        {data: 6},
        {data: 7}
      ]
    });
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

  $('#submission_product_name').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Purchase/search_product',
        dataType: 'json',
        type: 'GET',
        data: req,
        success: function(res) {
          if (res.success == true) {
            add(res.data);
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Silahkan Pilih Supplier Terlebih Dahulu',
            });
            $('#submission_product_name').val('');
          }
        },
      });
    },
    select: function(event, ui) {
      $('#submission_product_id').val(ui.item.id);
      $('#submission_product_code').val(ui.item.product_code);
    },
  });

  $('#btnsave').click(function(e){
    e.preventDefault();
    var submission_date           = $("#submission_date").val();
    var submission_warehouse      = $("#submission_warehouse").val();
    var submission_salesman       = $("#submission_salesman").val();
    var submission_desc           = $("#submission_desc").val();
    var submission_status         = $("#submission_status").val();
    var submission_product_id     = $("#submission_product_id").val();
    var submission_product_code   = $("#submission_product_code").val();
    var submission_qty            = $("#submission_qty").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/save_brand",
      dataType: "json",
      data: {submission_date:submission_date, submission_warehouse:submission_warehouse, submission_salesman:submission_salesman, submission_desc:submission_desc, submission_status:submission_status, submission_product_id:submission_product_id, submission_product_code:submission_product_code, submission_qty:submission_qty},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>Masterdata/brand";
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