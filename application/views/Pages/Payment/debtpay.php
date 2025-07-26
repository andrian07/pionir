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
      <h3 class="fw-bold mb-3">Pelunasan Hutang</h3>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="form-group row">
              <div class="row">
                <div class="col-sm-12 col-md-3">
                  <input id="supplier_id" name="supplier_id" type="hidden" class="form-control text-right" value="<?php echo $_GET['id']; ?>" readonly="">

                  <!-- text input -->
                  <div class="form-group">
                    <label>Nama Supplier</label>
                    <input id="supplier_name" name="supplier_name" type="text" class="form-control" readonly="">
                  </div>
                </div>
                <div class="col-sm-12 col-md-2">
                  <!-- text input -->
                  <div class="form-group">
                    <label>Tanggal Pembayaran</label>
                    <input id="repayment_date" name="repayment_date" type="date" class="form-control" value="2025-07-23">
                  </div>
                </div>

                <div class="col-sm-12 col-md-3">
                  <!-- text input -->
                  <div class="form-group">
                    <label>Metode Pembayaran</label>
                    <select id="payment_method_id" name="payment_method_id" class="form-control select2-hidden-accessible" data-select2-id="payment_method_id" tabindex="-1" aria-hidden="true"></select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="1" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-payment_method_id-container"><span class="select2-selection__rendered" id="select2-payment_method_id-container" role="textbox" aria-readonly="true"><span class="select2-selection__placeholder">-- Pilih Jenis Pembayaran --</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                  </div>
                </div>


                <div class="col-sm-12 col-md-2">
                  <!-- text input -->
                  <div class="form-group">
                    <label>User</label>
                    <input id="display_user" type="text" class="form-control" value="<?php echo $_SESSION['user_name']; ?>" readonly="">
                  </div>
                </div>
                <div class="col-sm-12 col-md-2">
                  <!-- text input -->
                  <div class="form-group">
                    <label>Total Hutang</label>
                    <input id="supplier_total_debt" name="supplier_total_debt" type="text" class="form-control text-right" value="0" readonly="">
                  </div>
                </div>
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

                <div class="col-sm-4">
                  <div class="form-group">
                    <label>No Invoice Pembelian</label>
                    <input id="purchase_inv" name="purchase_inv" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan No Invoice" value="" required="" autocomplete="off"  data-parsley-required data-parsley-required-message="*Masukan Nama Produk">
                    <input id="purchase_id" type="hidden" name="purchase_id">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Tgl Invoice</label>
                    <input id="purchase_invoice_date" name="purchase_invoice_date" type="date" class="form-control ui-autocomplete-input">
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Keterangan</label>
                    <input id="debt_desc" name="debt_desc" type="text" class="form-control">
                  </div>
                </div>


                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Saldo Hutang</label>
                    <input id="debt_nominal" name="debt_nominal" type="text" class="form-control text-right" value="0" readonly>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Total Retur</label>
                    <input id="debt_retur" name="debt_retur" type="text" class="form-control text-right" value="0" readonly>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Pembayaran</label>
                    <input id="debt_payment" name="debt_payment" type="text" class="form-control text-right" value="0">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Pembulatan / Disc</label>
                    <input id="debt_disc" name="debt_disc" type="text" class="form-control text-right" value="0">
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Remaining Debt</label>
                    <input id="new_remaining_debt" name="new_remaining_debt" type="text" class="form-control text-right" value="0" readonly>
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
              <table id="temp-debt-list" class="display table table-striped table-hover" >
                <thead>
                  <tr>
                    <th>No Invoice</th>
                    <th>Tgl Invoice</th>
                    <th>Saldo Hutang</th>
                    <th>Pembulatan/Disc</th>
                    <th>Pembayaran</th>
                    <th>Sisa Hutang</th>
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
                  <label for="footer_total_invoice" class="col-sm-7 col-form-label text-right:">Total Pembayaran:</label>
                  <div class="col-sm-5">
                    <input id="footer_total_pay" name="footer_total_pay" type="text" class="form-control text-right" value="0" readonly="">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="footer_total_invoice" class="col-sm-7 col-form-label text-right:">Total Nota:</label>
                  <div class="col-sm-5">
                    <input id="footer_total_nota" name="footer_total_nota" type="text" class="form-control text-right" value="0" readonly="">
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

  let supplier_total_debt = new AutoNumeric('#supplier_total_debt', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let debt_nominal = new AutoNumeric('#debt_nominal', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let debt_payment = new AutoNumeric('#debt_payment', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let debt_retur = new AutoNumeric('#debt_retur', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let debt_disc = new AutoNumeric('#debt_disc', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let new_remaining_debt = new AutoNumeric('#new_remaining_debt', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  $(document).ready(function() {
    get_header_debt_pay();
    tempdebt_table();
  });

  function tempdebt_table(){
    $('#temp-debt-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Payment/temp_debt_list',
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
      {data: 6}
      ]
    });
  }

  function get_header_debt_pay() {
    let supplier_id = $("#supplier_id").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Payment/get_header_debt_pay",
      dataType: "json",
      data: {supplier_id:supplier_id},
      success : function(data){
        if (data.code == "200"){
          let data_result = data.result[0];
          $("#supplier_name").val(data_result.supplier_name);
          supplier_total_debt.set(data_result.total_hutang);
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

  function edit(id){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Payment/get_debt_temp_by_id",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
          let data_row = data.result[0];
          $("#purchase_inv").val(data_row.hd_purchase_invoice);
          $("#purchase_id").val(data_row.hd_purchase_id);
          $("#purchase_invoice_date").val(data_row.hd_purchase_date);
          $("#debt_desc").val(data_row.temp_payment_debt_desc);
          debt_nominal.set(data_row.hd_purchase_remaining_debt);
          debt_payment.set(data_row.temp_payment_debt_nominal);
          debt_retur.set(data_row.temp_payment_debt_retur);
          debt_disc.set(data_row.temp_payment_debt_discount);
          new_remaining_debt.set(data_row.temp_payment_debt_new_remaining);
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

  $('#debt_payment').on('input', function (event) {
    debt_nominal_val = parseInt(debt_nominal.get());
    debt_retur_val   = parseInt(debt_retur.get());
    debt_payment_val = parseInt(debt_payment.get());
    debt_disc_val    = parseInt(debt_disc.get());    
    new_remaining_debt.set(debt_nominal_val - debt_retur_val - debt_payment_val - debt_disc_val);
  })

  $('#debt_disc').on('input', function (event) {
    debt_nominal_val = parseInt(debt_nominal.get());
    debt_retur_val   = parseInt(debt_retur.get());
    debt_payment_val = parseInt(debt_payment.get());
    debt_disc_val    = parseInt(debt_disc.get());    
    new_remaining_debt.set(debt_nominal_val - debt_retur_val - debt_payment_val - debt_disc_val);
  })
  
  $('#btnadd_temp').click(function(e){
    e.preventDefault();
    var purchase_id          = $("#purchase_id").val();
    var purchase_invoice_date         = $("#purchase_invoice_date").val();
    var debt_desc           = $("#debt_desc").val();
    var debt_nominal         = $("#debt_nominal").val();
    var purchase_warehouse   = $("#purchase_warehouse").val();
    var temp_price_submit    = parseInt(temp_price.get());
    var temp_qty             = $("#temp_qty").val();
    var temp_qty_buy         = $("#temp_qty_buy").val();
    var temp_ongkir_submit   = parseInt(temp_ongkir.get());
    var temp_total_submit    = parseInt(temp_total.get());
    var temp_note            = $("#temp_note").val();
    var supplier_id          = $('#purchase_supplier').val();

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

</script>