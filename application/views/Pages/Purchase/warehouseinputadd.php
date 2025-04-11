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
      <h3 class="fw-bold mb-3">Input Stock </h3>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">No Invoice :</label>
              <div class="col-sm-3">
                <input id="purchase_order_invoice" name="purchase_order_invoice" type="text" class="form-control" value="AUTO" readonly="">
                <input id="purchase_order_id" name="purchase_order_id" type="hidden" class="form-control">
              </div>
              <div class="col-sm-4"></div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">Tanggal :</label>
              <div class="col-sm-3">
                <input id="warehouseinput_date" name="warehouseinput_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly="">
              </div>
            </div>

            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">No PO:</label>
              <div class="col-sm-3">
                <input id="po_inv" name="po_inv" type="text" class="form-control ui-autocomplete-input" placeholder="Pilih PO">
              </div>
              <div class="col-sm-4"></div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">Gudang :</label>
              <div class="col-sm-3">
                <input id="warehouse_name" name="warehouse_name" type="text" class="form-control" readonly="">
              </div>
            </div>

            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">Supplier :</label>
              <div class="col-sm-3">
                <input id="supplier_name" name="supplier_name" type="text" class="form-control" readonly="">
              </div>
              <div class="col-sm-4"></div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">User :</label>
              <div class="col-sm-3">
                <input id="po_user_id" name="po_user_id" type="text" class="form-control" value="<?php echo $_SESSION['user_name']; ?>" readonly="">
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
                <input id="item_id" name="item_id" type="hidden" value="">

                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Produk</label>
                    <input id="product_name" name="product_name" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan nama produk" value="" required="" autocomplete="off"  data-parsley-required data-parsley-required-message="*Masukan Nama Produk"required="">
                    <input id="product_id" type="hidden" name="product_id">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Qty Beli</label>
                    <input id="temp_qty_po" name="temp_qty_po" type="text" class="form-control text-right" value="0" data-parsley-min="1" data-parsley-min-message="*qty harus lebih besar dari 0" required="">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Qty Terima</label>
                    <input id="temp_qty_recive" name="temp_qty_recive" type="text" class="form-control text-right" value="0" data-parsley-min="1" data-parsley-min-message="*qty harus lebih besar dari 0" required="">
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
              <table id="temp-po-list" class="display table table-striped table-hover" >
                <thead>
                  <tr>
                    <th>No Pengajuan</th>
                    <th>SKU</th>
                    <th>Porduk</th>
                    <th>Satuan</th>
                    <th>Qty</th>
                    <th>Ongkir</th>
                    <th>Total</th>
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
                    <textarea id="purchase_order_remark" name="purchase_order_remark" class="form-control" placeholder="Catatan" maxlength="500" rows="8"></textarea>
                  </div>
                </div>
              </div>

              <div class="col-lg-6 text-right">
                <div class="form-group row">
                  <label for="footer_sub_total" class="col-sm-7 col-form-label text-right:">Total Jenis Item:</label>
                  <div class="col-sm-5">
                    <input id="total_item_type" name="total_item_type" type="text" class="form-control text-right" value="0" readonly="">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="footer_sub_total" class="col-sm-7 col-form-label text-right:">Total Qty Terima:</label>
                  <div class="col-sm-5">
                    <input id="total_qty_item" name="total_qty_item" type="text" class="form-control text-right" value="0" readonly="">
                  </div>
                </div>
                <div class="form-group row">
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

  

  $(document).ready(function() {
    temppo_table();
  });

  function temppo_table(){
    $('#temp-po-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Purchase/temp_po_list',
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

  $('#submission_inv').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Purchase/search_submission',
        dataType: 'json',
        type: 'GET',
        data: req,
        success: function(res) {
          if (res.success == true) {
            add(res.data);
          }else{
            $('#submission_inv').val('');
          }
        },
      });
    },
    select: function(event, ui) {
      let id = ui.item.id;
      let product_name = ui.item.product_name;
      let product_id = ui.item.product_id;
      let product_price = ui.item.product_price;
      let product_weight = ui.item.product_weight;
      let code = ui.item.code;
      $('#submission_id').val(id);
      $('#submission_code').val(code);
      $('#product_name').val(product_name);
      $('#product_id').val(product_id);
      temp_price.set(product_price);
      $('#temp_weight').val(product_weight);
    },
  });

  $('#product_name').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Purchase/search_product_po?sup_id='+$('#po_supplier').val(),
        dataType: 'json',
        type: 'GET',
        data: req,
        success: function(res) {
          if (res.success == true) {
            add(res.data);
          }else{
            $('#submission_inv').val('');
          }
        },
      });
    },
    select: function(event, ui) {
      let id = ui.item.id;
      let product_name = ui.item.product_name;
      let product_id = ui.item.product_id;
      let product_price = ui.item.product_price;
      let product_weight = ui.item.product_weight;
      $('#submission_id').val(id);
      $('#submission_code').val('');
      $('#product_name').val(product_name);
      $('#product_id').val(product_id);
      temp_price.set(product_price);
      $('#temp_weight').val(product_weight);
    },
  });

  

  $('#temp_price').on('input', function (event) {
    let temp_price_val = parseInt(temp_price.get());
    let temp_qty_val = $('#temp_qty').val();
    let temp_weight_val = $('#temp_weight').val();
    let temp_total_weight_val = temp_qty_val * temp_weight_val;
    $('#temp_total_weight').val(temp_total_weight_val);
    let temp_ongkir_val = parseInt(temp_ongkir.get());
    let temp_total_val = temp_price_val * temp_qty_val + temp_ongkir_val;
    temp_total.set(temp_total_val);
  })

  $('#temp_qty').on('input', function (event) {
    let temp_price_val = parseInt(temp_price.get());
    let temp_qty_val = $('#temp_qty').val();
    let temp_weight_val = $('#temp_weight').val();
    let temp_total_weight_val = temp_qty_val * temp_weight_val;
    $('#temp_total_weight').val(temp_total_weight_val);
    let temp_ongkir_val = parseInt(temp_ongkir.get());
    let temp_total_val = temp_price_val * temp_qty_val + temp_ongkir_val;
    temp_total.set(temp_total_val);
  })



  $('#temp_delivery_price').on('input', function (event) {
    let temp_qty_val = $('#temp_qty').val();
    if(temp_qty_val == 0){
      temp_delivery_price.set(0);
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "Silahakn Isi Qty Terlebih Dahulu",
      })
    }else{
      let temp_price_val = parseInt(temp_price.get());
      let temp_delivery_price_val = parseInt(temp_delivery_price.get());
      let temp_total_weight_val = $('#temp_total_weight').val();
      let temp_ongkir_val = temp_delivery_price_val * temp_total_weight_val;
      temp_ongkir.set(temp_ongkir_val);
      let temp_total_val = temp_price_val * temp_qty_val + temp_ongkir_val;
      temp_total.set(temp_total_val);
    }
  })

  $('#edit_footer_discount_percentage1').on('input', function (event) {
    let footer_sub_total_val = parseInt(footer_sub_total.get());
    let edit_footer_discount_percentage1_val = parseInt(edit_footer_discount_percentage1.get());
    let edit_footer_discount1_val = footer_sub_total_val * edit_footer_discount_percentage1_val / 100;
    edit_footer_discount1.set(edit_footer_discount1_val);
  })

  $('#edit_footer_discount_percentage2').on('input', function (event) {
    let footer_sub_total_val = parseInt(footer_sub_total.get());
    let edit_footer_discount_percentage2_val = parseInt(edit_footer_discount_percentage2.get());
    let edit_footer_discount1_val = parseInt(edit_footer_discount1.get());
    let edit_footer_discount2_val = (footer_sub_total_val - edit_footer_discount1_val) * edit_footer_discount_percentage2_val / 100;
    edit_footer_discount2.set(edit_footer_discount2_val);
  })

  $('#edit_footer_discount_percentage3').on('input', function (event) {
    let footer_sub_total_val = parseInt(footer_sub_total.get());
    let edit_footer_discount_percentage3_val = parseInt(edit_footer_discount_percentage3.get());
    let edit_footer_discount1_val = parseInt(edit_footer_discount1.get());
    let edit_footer_discount2_val = parseInt(edit_footer_discount2.get());
    let edit_footer_discount3_val = (footer_sub_total_val - edit_footer_discount1_val - edit_footer_discount2_val) * edit_footer_discount_percentage3_val / 100;
    edit_footer_discount3.set(edit_footer_discount3_val);
  })
  

  $('#btnadd_temp').click(function(e){
    e.preventDefault();
    var submission_id           = $("#submission_id").val();
    var submission_code         = $("#submission_code").val();
    var product_id              = $("#product_id").val();
    var temp_price_val          = parseInt(temp_price.get());
    var temp_qty                = $("#temp_qty").val();
    var temp_weight             = $("#temp_weight").val();
    var temp_delivery_price_val = parseInt(temp_delivery_price.get());
    var temp_total_weight       = $("#temp_total_weight").val();
    var temp_ongkir_val         = parseInt(temp_ongkir.get());
    var temp_total_val          = parseInt(temp_total.get());

    if($('#formaddtemp').parsley().validate({force: true})){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Purchase/add_temp_po",
        dataType: "json",
        data: {submission_id:submission_id, submission_code:submission_code, product_id:product_id, temp_price_val:temp_price_val, temp_qty:temp_qty, temp_weight:temp_weight, temp_delivery_price_val:temp_delivery_price_val, temp_total_weight:temp_total_weight, temp_ongkir_val:temp_ongkir_val, temp_total_val:temp_total_val},
        success : function(data){
          if (data.code == "200"){
            let title = 'Tambah Data';
            let message = 'Data Berhasil Di Tambah';
            let state = 'info';
            notif_success(title, message, state);
            $('#temp-po-list').DataTable().ajax.reload();
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

  $('#btnsave').click(function(e){
    e.preventDefault();
    var po_supplier                              = $("#po_supplier").val();
    var po_date                                  = $("#po_date").val();
    var po_supplier                              = $("#po_supplier").val();
    var po_tax                                   = $("#po_tax").val();
    var po_ekspedisi                             = $("#po_ekspedisi").val();
    var po_top                                   = $("#po_top").val();
    var purchase_order_due_date                  = $("#purchase_order_due_date").val();
    var po_payment_method                        = $("#po_payment_method").val();
    var po_warehouse                             = $("#po_warehouse").val();
    var footer_sub_total_submit                  = parseInt(footer_sub_total.get());
    var footer_total_discount_submit             = parseInt(footer_total_discount.get());
    var edit_footer_discount_percentage1_submit  = parseInt(edit_footer_discount_percentage1.get());
    var edit_footer_discount_percentage2_submit  = parseInt(edit_footer_discount_percentage2.get());
    var edit_footer_discount_percentage3_submit  = parseInt(edit_footer_discount_percentage3.get());
    var edit_footer_discount1_submit             = parseInt(edit_footer_discount1.get());
    var edit_footer_discount2_submit             = parseInt(edit_footer_discount2.get());
    var edit_footer_discount3_submit             = parseInt(edit_footer_discount3.get());
    var footer_dpp_val                           = parseInt(footer_dpp.get());
    var footer_total_ppn_val                     = parseInt(footer_total_ppn.get());
    var footer_total_ongkir_val                  = parseInt(footer_total_ongkir.get());
    var footer_total_invoice_val                 = parseInt(footer_total_invoice.get());
    var purchase_order_remark                    = $("#purchase_order_remark").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/save_po",
      dataType: "json",
      data: {po_supplier:po_supplier, po_date:po_date, po_supplier:po_supplier, po_tax:po_tax, po_ekspedisi:po_ekspedisi, po_top:po_top, purchase_order_due_date:purchase_order_due_date, po_payment_method:po_payment_method, po_warehouse:po_warehouse, footer_sub_total_submit:footer_sub_total_submit, footer_total_discount_submit:footer_total_discount_submit, edit_footer_discount_percentage1_submit:edit_footer_discount_percentage1_submit, edit_footer_discount_percentage2_submit:edit_footer_discount_percentage2_submit, edit_footer_discount_percentage3_submit:edit_footer_discount_percentage3_submit, edit_footer_discount1_submit:edit_footer_discount1_submit, edit_footer_discount2_submit:edit_footer_discount2_submit, edit_footer_discount3_submit:edit_footer_discount3_submit, footer_dpp_val:footer_dpp_val, footer_total_ppn_val:footer_total_ppn_val, footer_total_ongkir_val:footer_total_ongkir_val, footer_total_invoice_val:footer_total_invoice_val, purchase_order_remark:purchase_order_remark},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>/Purchase/po";
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


  function deletes(id)
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
          url: "<?php echo base_url(); ?>Purchase/delete_temp_po",
          dataType: "json",
          data: {id:id},
          success : function(data){
            if (data.code == "200"){

              let title = 'Hapus Data';
              let message = 'Data Berhasil Di Hapus';
              let state = 'danger';
              notif_success(title, message, state);
              check_tempt_data();
              $('#temp-po-list').DataTable().ajax.reload();
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


  function edit_temp(id)
  {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/get_edit_temp_po",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
          var row = data.result[0];
          if(row.temp_submission_id != 0){
            $("#submission_inv").val(row.product_name+'('+row.submission_invoice +')');
            $("#submission_code").val(row.submission_invoice );
            $("#submission_id").val(row.submission_id);
          }else{
            $("#submission_inv").val("");
            $("#submission_code").val("");
            $("#submission_id").val(0);
          }
          $("#product_name").val(row.product_name);
          $("#product_id").val(row.submission_product_id);
          temp_price.set(row.temp_po_price);
          $("#temp_qty").val(row.temp_po_qty);
          $("#temp_weight").val(row.temp_po_weight);
          temp_delivery_price.set(row.temp_po_ongkir);
          $("#temp_total_weight").val(row.temp_po_total_weight);
          temp_ongkir.set(row.temp_po_total_ongkir);
          temp_total.set(row.temp_po_total);
        }
      }
    });  
  }

  function check_tempt_data()
  {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/check_temp_po",
      dataType: "json",
      data: {},
      success : function(data){
        if (data.code == "200"){
          if(data.supplier == 0){
            $("#po_supplier").select2("val", " ");
            $('#po_supplier').prop('disabled', false);
            $("#po_supplier_code").val('');
            $('#po_tax').val('');
            $('#po_tax').prop('disabled', false);
            footer_sub_total.set(0);
            footer_dpp.set(0); 
            footer_total_ppn.set(0);
            footer_total_ongkir.set(0);
            footer_total_invoice.set(0);
          }else{
            $("#po_supplier").select2("val", data.supplier);
            $('#po_supplier').prop('disabled', true);
            $("#po_supplier_code").val(data.supplier_code);
            $('#po_tax').val(data.product_tax);
            $('#po_tax').prop('disabled', true);
            footer_sub_total.set(data.sub_total);
            footer_dpp.set(data.sub_total); 
            if(data.product_tax == 'PPN'){
              var ppn_cal = data.sub_total * 11 / 100;
              footer_total_ppn.set(ppn_cal);
            }else{
              footer_total_ppn.set(0);
            }
            footer_total_ongkir.set(data.ongkir);
            var data_ongkir = parseInt(data.ongkir, 0);
            var data_sub_total = parseInt(data.sub_total, 0);
            var data_ppn_cal = parseInt(ppn_cal, 0);
            var footer_total_invoice_cal = (data_sub_total + data_ppn_cal + data_ongkir);
            footer_total_invoice.set(footer_total_invoice_cal);
          }
        }
      }
    });
  }

  function clear_input()
  {
    $('#submission_inv').val('');
    $("#submission_code").val('');
    $('#submission_id').val('');
    $('#product_name').val('');
    $('#product_id').val('');
    temp_price.set(0);
    $('#temp_qty').val('');
    $('#temp_weight').val('');
    temp_delivery_price.set(0);
    $('#temp_total_weight').val(0);
    temp_ongkir.set(0);
    temp_total.set(0);
  }

  function duedate_cal()
  {
    var po_top = document.getElementById("po_top").value;
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/cal_due_date",
      dataType: "json",
      data: {po_top:po_top},
      success : function(data){
        if (data.code == "200"){
          $('#purchase_order_due_date').val(data.result);
        }
      }
    });
  }


  $('#btneditdisc').click(function(e){
    e.preventDefault();
    var edit_footer_discount_percentage1_pop  = parseInt(edit_footer_discount_percentage1.get());
    var edit_footer_discount_percentage2_pop  = parseInt(edit_footer_discount_percentage2.get());
    var edit_footer_discount_percentage3_pop  = parseInt(edit_footer_discount_percentage3.get());
    var edit_footer_discount1_pop             = parseInt(edit_footer_discount1.get());
    var edit_footer_discount2_pop             = parseInt(edit_footer_discount2.get());
    var edit_footer_discount3_pop             = parseInt(edit_footer_discount3.get());
    var footer_sub_total_val                  = parseInt(footer_sub_total.get());
    var footer_total_ongkir_val               = parseInt(footer_total_ongkir.get());
    var total_disc = parseInt(edit_footer_discount1_pop + edit_footer_discount2_pop + edit_footer_discount3_pop);
    footer_total_discount.set(total_disc);
    footer_dpp.set(footer_sub_total_val - total_disc);
    footer_total_ppn.set((footer_sub_total_val - total_disc) * 11 / 100);
    footer_total_invoice.set(((footer_sub_total_val - total_disc) + (footer_sub_total_val - total_disc) * 11 / 100) + footer_total_ongkir_val);
    $('#footerdiscount').modal('hide')
  });

  

  new bootstrap.Modal(document.getElementById('footerdiscount'), {backdrop: 'static', keyboard: false})  
  
</script>