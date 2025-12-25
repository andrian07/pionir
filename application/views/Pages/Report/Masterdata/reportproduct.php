<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
<style type="text/css">
  .card-pricing .specification-list li {
    font-size: 13px;
  }
  .card.card-pricing {
    height: 602px;
  }
  .card-pricing .specification-list li {
    border-bottom: 1px solid #000 !important;
  }
</style>
</div>

<div class="container">
  <div class="page-inner">
    <div class="page-header">

    </div>
    <div class="row">
      <h3 class="fw-bold mb-3">Laporan Produk </h3>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="card-body">
              <form>
                <div class="row">
                  <div class="col-sm-3">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Brand:</label>
                      <select class="form-control input-full js-example-basic-single" id="brand_report" name="brand_report">
                        <option value="">-- Pilih Brand --</option>
                        <?php foreach ($data['brand_list'] as $row) { ?>
                          <option value="<?php echo $row->brand_id; ?>"><?php echo $row->brand_name; ?></option>  
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Kategori:</label>
                      <select class="form-control input-full js-example-basic-single" id="category_report" name="category_report">
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($data['category_list'] as $row) { ?>
                          <option value="<?php echo $row->category_id; ?>"><?php echo $row->category_name; ?></option>  
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Supplier:</label>
                      <select class="form-control input-full js-example-basic-single" id="Supplier_report" name="Supplier_report">
                        <option value="">-- Pilih Supplier --</option>
                        <?php foreach ($data['supplier_list'] as $row) { ?>
                          <option value="<?php echo $row->supplier_id; ?>"><?php echo $row->supplier_name; ?></option>  
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <iframe id="preview" src="<?php echo base_url(); ?>Reportmaster/reportproductpdf" width="100%" height="1000px"></iframe>
          </div>
        </div>

      </div>
    </div>
  </div>

  <?php 
  require DOC_ROOT_PATH . $this->config->item('footer');
  ?>

  <script type="text/javascript">

    $('#btnsearch').click(function(e) {
      e.preventDefault();
      let start_date = $('#start_date').val();
      let end_date = $('#end_date').val();
      let customer_id = $('#customer_id').val();

      let url = '<?php echo base_url(); ?>Reportpayment/repayment_pdf?';
      url += '&start_date=' + start_date;
      url += '&end_date=' + end_date;
      url += '&customer_id=' + customer_id;
      $('#preview').attr('src', url);
    })


    $('#btndownloadexcell').click(function(e) {
      e.preventDefault();

      let start_date = $('#start_date').val();
      let end_date = $('#end_date').val();
      let customer_id = $('#customer_id').val();

      let url = '<?php echo base_url(); ?>Reportpayment/repayment_excell?';
      url += '&start_date=' + start_date;
      url += '&end_date=' + end_date;
      url += '&customer_id=' + customer_id;

      window.open(url, '_blank');
    })
  </script>