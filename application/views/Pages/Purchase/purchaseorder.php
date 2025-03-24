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
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                Dari: <input id="start_date" name="start_date" type="date" class="form-control" value="">
              </div>
              <div class="col-md-3">
                Sampai: <input id="end_date" name="end_date" type="date" class="form-control" value="">
              </div>
              <div class="col-md-3">
                Supplier: 
                <select class="form-control js-example-basic-single" id="supplier_filter" name="supplier_filter">
                  <option>-- Pilih Supplier --</option>
                  <?php foreach ($supplier_list as $row) { ?>
                    <option value="<?php echo $row->supplier_id; ?>"><?php echo $row->supplier_name; ?></option>  
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-3">
                <button type="button" class="btn btn-warning" id="search" style="margin-top:22px;"><i class="fas fa-search"></i> Search</button>
                <button type="button" class="btn btn-primary" id="search" style="margin-top:22px;"> Clear</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-left">
              <div>
                <h3 class="fw-bold mb-3">Daftar PO</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-info" id="reload"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                <a href="<?php echo base_url(); ?>Purchase/addpo"><button class="btn btn-primary"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button></a>
              </div>
            </div>
          </div>
          <div class="card-body">
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