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
      <h3 class="fw-bold mb-3">Tambah PO </h3>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">No Invoice :</label>
              <div class="col-sm-3">
                <input id="purchase_order_invoice" name="purchase_order_invoice" type="text" class="form-control" value="AUTO" readonly="">
                <input id="purchase_order_id" name="purchase_order_id" type="hidden" class="form-control">
              </div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">T.O.P :</label>
              <div class="col-sm-3">
                <select class="form-control input-full js-example-basic-single" id="po_top" name="po_top">
                  <option>-- Pilih T.O.P --</option>
                  <option value="CBD">CBD</option>
                  <option value="JT7">JT7</option>
                  <option value="JT15">JT15</option>
                  <option value="JT30">JT30</option>
                  <option value="JT45">JT45</option>
                  <option value="JT60">JT60</option>
                  <option value="JT90">JT90</option>
                </select>
              </div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">Tanggal :</label>
              <div class="col-sm-3">
                <input id="purchase_order_date" name="purchase_order_date" type="date" class="form-control" value="2025-03-21" readonly="">
              </div>
            </div>

            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">Supplier Baru:</label>
              <div class="col-sm-3">
                <select class="form-control input-full js-example-basic-single" id="po_supplier" name="po_supplier">
                  <option>-- Pilih Supplier --</option>
                  <?php foreach ($data['supplier_list'] as $row) { ?>
                    <option value="<?php echo $row->supplier_id; ?>"><?php echo $row->supplier_name; ?></option>  
                  <?php } ?>
                </select>
              </div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">Jatuh Tempo :</label>
              <div class="col-sm-3">
                <input id="purchase_order_date" name="purchase_order_date" type="date" class="form-control" value="2025-03-21" readonly="">
              </div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">Gudang :</label>
              <div class="col-sm-3">
                <select class="form-control input-full js-example-basic-single" id="po_warehouse" name="po_warehouse">
                  <option>-- Pilih Gudang --</option>
                  <?php foreach ($data['warehouse_list'] as $row) { ?>
                    <option value="<?php echo $row->warehouse_id; ?>"><?php echo $row->warehouse_name; ?></option>  
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">Golongan :</label>
              <div class="col-sm-3">
                <select class="form-control" id="po_tax" name="po_tax">
                  <option value="Y">BKP</option>
                  <option value="N">NON BKP</option>
                </select>
              </div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">Metode Bayar :</label>
              <div class="col-sm-3">
                <select class="form-control input-full js-example-basic-single" id="po_payment_method" name="po_payment_method">
                  <option>-- Pilih Metode Bayar --</option>
                  <?php foreach ($data['payment_list'] as $row) { ?>
                    <option value="<?php echo $row->payment_id; ?>"><?php echo $row->payment_name; ?></option>  
                  <?php } ?>
                </select>
              </div>
              <label for="tanggal" class="col-sm-1 col-form-label text-right">User :</label>
              <div class="col-sm-3">
                <input id="po_user_id" name="po_user_id" type="text" class="form-control" value="<?php echo $_SESSION['user_name']; ?>" readonly="">
              </div>
            </div>

            <div class="form-group row">
              <label for="noinvoice" class="col-sm-1 col-form-label text-right">Ekspedisi :</label>
              <div class="col-sm-3">
                <select class="form-control input-full js-example-basic-single" id="po_ekspedisi" name="po_ekspedisi">
                  <option>-- Pilih Ekspedisi --</option>
                  <?php foreach ($data['ekspedisi_list'] as $row) { ?>
                    <option value="<?php echo $row->ekspedisi_id; ?>"><?php echo $row->ekspedisi_name; ?></option>  
                  <?php } ?>
                </select>
              </div>
              <div class="col-sm-8"></div>
            </div>


          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row well well-sm input-temp">
              <input id="temp_po_id" name="temp_po_id" type="hidden" value="">
              <input id="item_id" name="item_id" type="hidden" value="">
              <div class="col-md-4">
                <div class="form-group">
                  <label>No Pengajuan:</label>
                  <input id="submission_inv" name="submission_inv" type="text" class="form-control ui-autocomplete-input" placeholder="Pilih Pengajuan">
                  <input id="submission_id" type="hidden" name="submission_id">
                </div>
              </div>
              

              <div class="col-sm-4">
                <div class="form-group">
                  <label>Produk</label>
                  <input id="product_name" name="product_name" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan nama produk" value="" required="" autocomplete="off">
                  <input id="product_id" type="hidden" name="product_id">
                </div>
              </div>

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Harga Beli Per Unit</label>
                  <input id="temp_price" name="temp_price" class="form-control text-right" value="0">
                  <input id="temp_dpp" name="temp_dpp" type="hidden" class="form-control text-right" value="Rp 0.00" required="">
                  <input id="temp_tax" name="temp_tax" type="hidden" class="form-control text-right" value="Rp 0.00" readonly="" required="">
                </div>
              </div>


              <div class="col-sm-2">
                <div class="form-group">
                  <label>Qty</label>
                  <input id="temp_qty" name="temp_qty" type="text" class="form-control text-right" value="0">
                </div>
              </div>



              <div class="col-sm-2">
                <div class="form-group">
                  <label>Berat</label>
                  <input id="temp_weight" name="temp_weight" type="text" class="form-control text-right" value="0">
                </div>
              </div>

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Ongkir</label>
                  <input id="temp_delivery_price" name="temp_delivery_price" type="text" class="form-control text-right" value="0">
                </div>
              </div>

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Total Berat</label>
                  <input id="temp_total_weight" name="temp_total_weight" type="text" class="form-control text-right" value="0" readonly>
                </div>
              </div>

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Total Ongkir</label>
                  <input id="temp_ongkir" name="temp_ongkir" type="text" class="form-control text-right" value="0" readonly>
                </div>
              </div>


              <div class="col-sm-3">

                <!-- text input -->

                <div class="form-group">

                  <label>Total</label>

                  <input id="temp_total" name="temp_total" type="text" class="form-control text-right" value="0" readonly="">

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

            <div class="table-responsive">
              <table
              id="temp-po-list"
              class="display table table-striped table-hover"
              >
              <thead>
                <tr>
                  <th>No Pengajuan</th>
                  <th>SKU</th>
                  <th>Porduk</th>
                  <th>Satuan</th>
                  <th>Qty</th>
                  <th>Diskon</th>
                  <th>Ongkir</th>
                  <th>Total</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
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

  let temp_price = new AutoNumeric('#temp_price', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let temp_total = new AutoNumeric('#temp_total', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let temp_delivery_price = new AutoNumeric('#temp_delivery_price', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let temp_ongkir = new AutoNumeric('#temp_ongkir', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });
  

  

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
        {data: 7},
        {data: 8}
      ]
    });
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
      console.log(ui);
      let id = ui.item.id;
      let product_name = ui.item.product_name;
      let product_id = ui.item.product_id;
      let product_price = ui.item.product_price;
      let product_weight = ui.item.product_weight;
      $('#submission_id').val(id);
      $('#product_name').val(product_name);
      $('#product_id').val(product_id);
      temp_price.set(product_price);
      $('#temp_weight').val(product_weight);
    },
  });


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

  
  
  $('#btnadd_temp').click(function(e){
    e.preventDefault();
    var submission_id           = $("#submission_id").val();
    var product_id              = $("#product_id").val();
    var temp_price_val          = parseInt(temp_price.get());
    var temp_qty                = $("#temp_qty").val();
    var temp_weight             = $("#temp_weight").val();
    var temp_delivery_price_val = parseInt(temp_delivery_price.get());
    var temp_total_weight       = $("#temp_total_weight").val();
    var temp_ongkir_val         = parseInt(temp_ongkir.get());
    var temp_total_val          = parseInt(temp_total.get());
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Purchase/add_temp_po",
      dataType: "json",
      data: {submission_id:submission_id, product_id:product_id, temp_price_val:temp_price_val, temp_qty:temp_qty, temp_weight:temp_weight, temp_delivery_price_val:temp_delivery_price_val, temp_total_weight:temp_total_weight, temp_ongkir_val:temp_ongkir_val, temp_total_val:temp_total_val},
      success : function(data){
        if (data.code == "200"){
          temppo_table();
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