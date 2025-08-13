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
      <h3 class="fw-bold mb-3">Tambah Transfer Stok</h3>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">

            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">Kode Transfer :</label>
              <div class="col-sm-3">
                <input id="transfer_stock_code" name="transfer_stock_code" type="text" class="form-control" value="AUTO" readonly="">
              </div>
              <div class="col-md-4"></div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">Tanggal :</label>
              <div class="col-sm-3">
                <input id="transfer_stock_date" name="transfer_stock_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-8"></div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">User :</label>
              <div class="col-sm-3">
                <input id="transfer_stock_user" name="transfer_stock_user" type="text" class="form-control" value="<?php echo $_SESSION['user_name']; ?>" readonly>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <form id="formaddtemp">
              <div class="row well well-sm input-temp">

                <div class="col-sm-5">
                  <div class="form-group">
                    <label>Produk</label>
                    <input id="product_name" name="product_name" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan Nama Produk" value="" required="" autocomplete="off"  data-parsley-required data-parsley-required-message="*Masukan Nama Produk">
                    <input id="product_id" type="hidden" name="product_id">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Dari</label>
                    <select class="form-control input-full js-example-basic-single" id="transfer_from" name="transfer_from">
                      <option value="">-- Pilih Gudang --</option>
                      <?php foreach ($data['warehouse_list'] as $row) { ?>
                        <option value="<?php echo $row->warehouse_id; ?>"><?php echo $row->warehouse_name; ?></option>  
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Tujuan</label>
                    <select class="form-control input-full js-example-basic-single" id="transfer_to" name="transfer_to">
                      <option value="">-- Pilih Gudang --</option>
                      <?php foreach ($data['warehouse_list'] as $row) { ?>
                        <option value="<?php echo $row->warehouse_id; ?>"><?php echo $row->warehouse_name; ?></option>  
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Qty</label>
                    <input id="temp_qty" name="temp_qty" type="text" class="form-control text-right" value="0" data-parsley-min="1" data-parsley-min-message="*qty harus lebih besar dari 0" required="">
                  </div>
                </div>

                <div class="col-sm-5"></div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Catatan</label>
                    <input id="temp_note" name="temp_note" type="text" class="form-control text-left">
                  </div>
                </div>

                <div class="col-sm-1" style="padding-right: 62px;">

                  <!-- text input -->

                  <label>&nbsp;</label>

                  <div class="form-group">

                    <button id="btnadd_temp" class="btn btn-md btn-primary rounded-circle float-right btn-add-temp"><i class="fas fa-plus"></i></button>

                  </div>

                </div>

              </div>
            </form>

            <div class="table-responsive">
              <table id="temp-transfer-stock-list" class="display table table-striped table-hover" >
                <thead>
                  <tr>
                    <th>SKU</th>
                    <th>Porduk</th>
                    <th>Satuan</th>
                    <th>Qty</th>
                    <th>Dari</th>
                    <th>Tujuan</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>

            <div class="row form-space">
              <div class="col-lg-6">
                <div class="form-group">
                  <div class="col-sm-12">
                    <textarea id="purchase_retur_remark" name="purchase_retur_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="8"></textarea>
                  </div>
                </div>
              </div>

              <div class="col-lg-6 text-right">
                <div class="form-group row">
                  <label for="footer_total" class="col-sm-7 col-form-label text-right:">Total Item:</label>
                  <div class="col-sm-5">
                    <input id="footer_total" name="footer_total" type="text" class="form-control text-right" value="0" readonly="">
                  </div>
                </div>
                <div class="form-group row" style="margin-top: 20px;">
                  <div class="col-sm-12">
                    <button id="btncancel" class="btn btn-danger"><i class="fas fa-times-circle"></i> Batal</button>
                    <button id="btnsave" class="btn btn-success button-header-custom-save"><i class="fas fa-save"></i> Simpan</button>
                  </div>
                </div>
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



  $('#purchase_warehouse').prop('disabled', true);



  $(document).ready(function() {
    temp_retur_purchase_table();
  });

  $('#product_name').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Transferstock/search_product',
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
              text: res.message,
            })
          }
        },
      });
    },
    select: function(event, ui) {
      let id = ui.item.id;
      $("#product_id").val(id);
    },
  });

  $('#btnadd_temp').click(function(e){
    e.preventDefault();
    var product_id           = $("#product_id").val();
    var transfer_from        = $("#transfer_from").val();
    var transfer_to          = $("#transfer_to").val();
    var qty                  = $("#temp_qty").val();
    var temp_note            = $("#temp_note").val();

    if($('#formaddtemp').parsley().validate({force: true})){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Purchase/add_temp_retur_purchase",
        dataType: "json",
        data: {purchase_id:purchase_id, purchase_inv:purchase_inv, product_id:product_id, product_name:product_name, purchase_warehouse:purchase_warehouse, temp_price_submit:temp_price_submit, temp_qty:temp_qty, temp_qty_buy:temp_qty_buy, temp_ongkir_submit:temp_ongkir_submit, temp_total_submit:temp_total_submit, temp_note:temp_note, supplier_id:supplier_id},
        success : function(data){
          if (data.code == "200"){
            let title = 'Tambah Data';
            let message = 'Data Berhasil Di Tambah';
            let state = 'info';
            notif_success(title, message, state);
            $('#temp-retur-purchase-list').DataTable().ajax.reload();
            check_tempt_data();
            clear_input();
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data.result,
            })
          }
        }
      });
    }
  });

  function check_tempt_data()
  {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Transferstock/check_temp_transfer_stock",
      dataType: "json",
      data: {},
      success : function(data){
        if (data.code == "200"){
          let row = data.data[0];
          $('#footer_total').val(row.total);
        }
      }
    });
  }

  function clear_input()
  {
    $("#purchase_id").val("");
    $("#purchase_inv").val("");
    $("#product_id").val("");
    $("#product_name").val("");
    $("#purchase_warehouse").val("");
    temp_price.set(0);
    $("#temp_qty").val(0);
    $("#temp_qty_buy").val(0);
    temp_ongkir.set(0);
    temp_total.set(0);
    $("#temp_note").val("");
  }

  function edit_temp(id, purchase_id)
  {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/get_edit_temp_retur_purchase",
      dataType: "json",
      data: {id:id, purchase_id:purchase_id},
      success : function(data){
        if (data.code == "200"){
          let row = data.result[0];
          $("#purchase_inv").val(row.temp_retur_purchase_b_inv);
          $("#purchase_id").val(row.temp_retur_purchase_b_id);
          $("#product_name").val(row.temp_retur_purchase_product_name);
          $("#product_id").val(row.temp_retur_purchase_product_id);
          $("#purchase_warehouse").val(row.temp_retur_purchase_warehouse_id);
          $('#purchase_warehouse').trigger('change');
          temp_price.set(row.temp_retur_purchase_price);
          $("#temp_qty").val(row.temp_retur_purchase_qty);
          $("#temp_qty_buy").val(row.temp_retur_purchase_qty_buy);
          temp_ongkir.set(row.temp_retur_purchase_ongkir);
          temp_total.set(row.temp_retur_purchase_total);
          $("#temp_note").val(row.temp_retur_purchase_note);
        }
      }
    });
  }

  function temp_retur_purchase_table(){
    $('#temp-transfer-stock-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Transferstock/temp_transfer_stock_list',
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
    check_tempt_data();
  }

  function deletes(id, purchase_id)
  {
    Swal.fire({
      title: 'Konfirmasi?',
      text: "Apakah Anda Yakin Menghapus Data ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Purchase/delete_temp_retur_purchase",
          dataType: "json",
          data: {id:id, purchase_id:purchase_id},
          success : function(data){
            if (data.code == "200"){
              let title = 'Hapus Data';
              let message = 'Data Berhasil Di Hapus';
              let state = 'danger';
              notif_success(title, message, state);
              check_tempt_data();
              $('#temp-retur-purchase-list').DataTable().ajax.reload();
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.result,
              })
            }
          }
        });
      }
    })
  }

  $('#btnsave').click(function(e){
    e.preventDefault();
    var retur_purchase_supplier                  = $("#purchase_supplier").val();
    var retur_purchase_date                      = $("#retur_purchase_date").val();
    var footer_total_invoice_val                 = parseInt(footer_total_invoice.get());
    var purchase_retur_remark                    = $("#purchase_retur_remark").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/save_retur_purchase",
      dataType: "json",
      data: {retur_purchase_supplier:retur_purchase_supplier, retur_purchase_date:retur_purchase_date, footer_total_invoice_val:footer_total_invoice_val, purchase_retur_remark:purchase_retur_remark},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>/Purchase/returpurchase";
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