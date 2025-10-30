<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
<style type="text/css">
  .image-td{
    width: 15%;
  }

  @media only screen and (max-width: 600px) {
    .image-td{
      width: 35%;
    }
  }
</style>
</div>

<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3" style="padding-left: 20px;">Informasi Produk</h3>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div id="info" class="col-12"></div>

              <div class="col-12">
                <label style="font-weight: 700; margin-bottom: 5px; margin-left:5px;">Barcode / Nama Produk</label>
              </div>
              <div class="col-sm-10">
                <!-- text input -->
                <div class="form-group">
                  <input id="key" name="key" type="text" class="form-control ui-autocomplete-input" placeholder="Barcode atau Nama Produk" value="" autocomplete="off">
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">


             <table class="table table-hover">
              <tbody id="product_list">

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
  product_list_table();
});


 let formatter = new Intl.NumberFormat('id-ID', {
  style: 'currency',
  currency: 'IDR',
  minimumFractionDigits: 0
});


 function product_list_table(key = '') {
  $.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>Search/product_list",
    dataType: "json",
    data: {key:key},
    success : function(data){

      let text = "";
      for (let i = 0; i < data.length; i++) {
        if(data[i].total_stock == null){
          var stocks = 0;
        }else{
          var stocks = data[i].total_stock;
        }
        text+= '<tr onclick="popupOpen('+data[i].product_id+')"><td class="image-td"><img src="<?php echo base_url(); ?>assets/products/'+data[i].product_image+'" width="100%"></img></td><td>'+data[i].product_name+'<br /> <span class="badge badge-primary">'+formatter.format(data[i].product_sell_price_1)+'</span></td><td>'+stocks+' '+data[i].unit_name+'</td></tr>';
      }       
      document.getElementById("product_list").innerHTML = text;
    }
  });
}

$('#key').on('input', function (event) {
  var key = this.value;
  product_list_table(key);
})


function popupOpen(id) {
  let link = window.location.origin + window.location.pathname + '/detailsearch?id='+id;
  Fancybox.show([
    {
      src: link,
      type: "iframe",
      preload: false,
      top:0,
    },
  ]);
}

</script>