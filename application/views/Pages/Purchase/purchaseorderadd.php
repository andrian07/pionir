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
              <div class="col-md-3">
                <label>No Pengajuan:</label>
                <select id="nosubmission" name="nosubmission" class="form-control select2-hidden-accessible" data-select2-id="nosubmission" tabindex="-1" aria-hidden="true"></select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="1" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-nosubmission-container"><span class="select2-selection__rendered" id="select2-nosubmission-container" role="textbox" aria-readonly="true"><span class="select2-selection__placeholder">-- Pilih No Pengajuan --</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                <input id="submission_id" type="hidden" name="submission_id">
                <input id="submission_inv" type="hidden" name="submission_inv">
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label>Produk</label>
                  <input id="product_name" name="product_name" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan nama produk" value="" data-parsley-vproductname="" required="" autocomplete="off">
                </div>
              </div>

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Harga Beli Per Unit</label>
                  <input id="temp_price" name="temp_price" class="form-control text-right" value="0" data-parsley-vprice="" required="">
                  <input id="temp_dpp" name="temp_dpp" type="hidden" class="form-control text-right" value="Rp 0.00" required="">
                  <input id="temp_tax" name="temp_tax" type="hidden" class="form-control text-right" value="Rp 0.00" readonly="" required="">
                </div>
              </div>


              <div class="col-sm-2">
                <div class="form-group">
                  <label>Qty</label>
                  <input id="temp_qty" name="temp_qty" type="text" class="form-control text-right" value="0" data-parsley-vqty="" required="">
                  <input id="total_price" name="total_price" type="hidden" class="form-control text-right" value="Rp 0.00" required="">
                </div>
              </div>

              <div class="col-md-5"></div>

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Ongkir</label>
                  <input id="temp_ongkir" name="temp_ongkir" type="text" class="form-control text-right" value="0">
                </div>
              </div>
              
              <div class="col-sm-2" style="display:none;">

                <!-- text input -->

                <div class="form-group">

                  <label>Discount</label>

                  <input id="temp_discount1" name="temp_discount1" type="hidden" class="form-control text-right" value="Rp 0.00" readonly="">
                  <input id="temp_discount2" name="temp_discount2" type="hidden" class="form-control text-right" value="Rp 0.00" readonly="">
                  <input id="temp_discount3" name="temp_discount3" type="hidden" class="form-control text-right" value="Rp 0.00" readonly="">
                  <input id="temp_discount_percentage1" name="temp_discount_percentage1" type="hidden" class="form-control text-right" value="0.00%" readonly="">
                  <input id="temp_discount_percentage2" name="temp_discount_percentage2" type="hidden" class="form-control text-right" value="0.00%" readonly="">
                  <input id="temp_discount_percentage3" name="temp_discount_percentage3" type="hidden" class="form-control text-right" value="0.00%" readonly="">
                  <input id="total_temp_discount" name="total_temp_discount" type="text" class="form-control text-right" value="0" readonly="">

                </div>

              </div>


              <div class="col-sm-2" style="display:none;">

                <!-- text input -->

                <div class="form-group">

                  <label>Expire Date</label>

                  <input id="temp_ed_date" name="temp_ed_date" type="date" class="form-control">

                </div>

              </div>


              <div class="col-sm-4">

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

                  <button id="btnadd_temp" class="btn btn-md btn-primary rounded-circle float-right"><i class="fas fa-plus"></i></button>

                </div>

              </div>

            </div>

            <div class="table-responsive">
              <table
              id="po-list"
              class="display table table-striped table-hover"
              >
              <thead>
                <tr>
                  <th>No PO</th>
                  <th>Tgl. PO</th>
                  <th>Nama Produk</th>
                  <th>Golongan</th>
                  <th>Supplier</th>
                  <th>Harga</th>
                  <th>Total Harga</th>
                  <th>Status</th>
                  <th>Status Pengiriman</th>
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

  $(document).ready(function() {
    purchaseorder_table();
  });

  function purchaseorder_table(){
    $('#po-list').DataTable( {
      serverSide: true,
      search: true,
      processing: true,
      ordering: false,
      retrieve: true,
      ajax: {
        url: '<?php echo base_url(); ?>Purchase/po_list',
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
        {data: 8},
        {data: 9}
      ]
    });
  }

  
</script>