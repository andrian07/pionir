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
                <h3 class="fw-bold mb-3">Daftar Produk</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <div class="btn-group dropdown">
                  <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"><span class="btn-label"><i class="fas fa-file-excel"></i></span> Excell</button>
                  <ul class="dropdown-menu" role="menu">
                    <li>
                      <a class="dropdown-item" href="#">Download Template</a>
                      <a class="dropdown-item" href="#">Import Excell</a>
                    </li>
                  </ul>
                </div>
                <button class="btn btn-info"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".bd-example-modal-xl"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button>
                <div class="modal fade bd-example-modal-xl" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-4 border-right">

                            <div class="form-group form-inline">
                              <div class="proof">
                                <div class="imgArea" data-title="">
                                  <input type="file" name="screenshoot" id="screenshoot" hidden accept="image/*" />
                                  <i class="fa-solid fa-cloud-arrow-up"></i>
                                  <h4>upload screenshoot</h4>
                                  <p>image size must be less than <span>2MB</span></p>
                                </div>
                                <button class="selectImage" type="button">Select Image</button>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Kode Produk</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="product_code" value="Auto" readonly>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Nama Produk</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="product_name" placeholder="Nama Produk">
                              </div>
                            </div>


                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Kategori</label>
                              <div class="col-md-12 p-0">
                                <select class="form-control input-full js-example-basic-single" id="product_category" name="product_category">
                                  <option>-- Pilih Kategori --</option>
                                  <option>Headset</option>
                                  <option>Monitor</option>
                                  <option>Speaker</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Brand</label>
                              <div class="col-md-12 p-0">
                                <select class="form-control input-full js-example-basic-single" id="product_brand" name="product_brand">
                                  <option>-- Pilih Brand --</option>
                                  <option>ACR</option>
                                  <option>ACA</option>
                                  <option>ACTIV</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Supplier</label>
                              <div class="col-md-12 p-0">
                                <select class=" form-control input-full js-example-basic-multiple js-states" name="states[]" id="customer_expedisi" multiple="multiple">
                                  <option>-- Pilih Supplier --</option>
                                  <option value="PJ">Prima Jasa</option>
                                  <option value="LP">Lion Parcel</option>
                                  <option value="JNE">JNE</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Item Supplier</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="product_item_supplier" placeholder="Item Supplier">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Golongan Produk</label>
                              <div class="col-md-12 p-0">
                                <select class="form-select form-control" id="product_tax">
                                  <option value="Y">Barang Kena Pajak</option>
                                  <option value="N">Barang Tidak Kena Pajak</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Satuan Dasar</label>
                              <div class="col-md-12 p-0">
                                <select class="form-control input-full js-example-basic-single" id="product_unit" name="product_unit">
                                  <option>-- Pilih Satuan Dasar --</option>
                                  <option>Pcs</option>
                                  <option>Kotak</option>
                                  <option>Lusin</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Jenis Produk</label>
                              <div class="col-md-12 p-0">
                                <select class="form-select form-control" id="product_type">
                                  <option value="Produk">Produk</option>
                                  <option value="Paket">Paket</option>
                                </select>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Min Stok</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="product_min_stock" placeholder="Min Stok">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Berat</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="product_weight" placeholder="Berat">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Lokasi</label>
                              <div class="col-md-12 p-0">
                                <textarea class="form-control" id="product_location" rows="4"></textarea>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Deskripsi</label>
                              <div class="col-md-12 p-0">
                                <textarea class="form-control" id="product_description" rows="4"></textarea>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Kata Kunci</label>
                              <div class="col-md-12 p-0">
                                <textarea class="form-control" id="product_search_key" rows="4"></textarea>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
                        <button type="button" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">

            <div class="row" style="margin-bottom:30px; padding-left: 8px;">

              <div class="col-md-3">
                <div class="form-group form-inline">
                  <label for="inlineinput" class="col-md-3 col-form-label">Kategori</label>
                  <div class="col-md-12 p-0">
                    <select class="form-control input-full js-example-basic-single" id="product_category_filter" name="product_category_filter">
                      <option>-- Pilih Kategori --</option>
                      <option>Headset</option>
                      <option>Monitor</option>
                      <option>Speaker</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group form-inline">
                  <label for="inlineinput" class="col-md-3 col-form-label">Brand</label>
                  <div class="col-md-12 p-0">
                    <select class="form-control input-full js-example-basic-single" id="product_brand_filter" name="product_brand_filter">
                      <option>-- Pilih Brand --</option>
                      <option>ACR</option>
                      <option>ACA</option>
                      <option>ACTIV</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group form-inline">
                  <label for="inlineinput" class="col-md-3 col-form-label">Supplier</label>
                  <div class="col-md-12 p-0">
                    <select class="form-control input-full js-example-basic-single" id="product_supplier_filter" name="product_supplier_filter">
                      <option>-- Pilih Supplier --</option>
                      <option value="PJ">Prima Jasa</option>
                      <option value="LP">Lion Parcel</option>
                      <option value="JNE">JNE</option>
                    </select>
                  </div>
                </div>
              </div>
              
            </div>

            <div class="table-responsive">
              <table
              id="basic-datatables"
              class="display table table-striped table-hover"
              >
              <thead>
                <tr>
                  <th width="30%">Nama Produk</th>
                  <th>Brand</th>
                  <th>Kategori</th>
                  <th>Supplier</th>
                  <th>Paket</th>
                  <th>PPN</th>
                  <th width="20%;">Gambar</th>
                  <th width="10%;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>BAT00075 <br /> Baterai Dynamax A2</td>
                  <td>ACR</td>
                  <td>Baterai</td>
                  <td><span class="badge badge-primary multi-badge">Jaya ACR</span><span class="badge badge-primary multi-badge">CV Arta</span></td>
                  <td><span class="badge badge-danger multi-badge"><i class="fas fa-times-circle"></i></span></td>
                  <td><span class="badge badge-success multi-badge"><i class="fas fa-check-circle"></i></span></td>
                  <td>
                    <a data-fancybox data-src="<?php echo base_url();?>assets/default.png" data-caption="Adaptor 12v 1A HK (Pipih)">
                      <img src="<?php echo base_url();?>assets/default.png"class="img-thumbnail" width="80%" />
                    </a>
                  </td>
                  <td>
                    <a href="<?php echo base_url();?>Masterdata/settingproduct">
                      <button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn"><i class="fas fa-cog"></i></button>
                    </a>
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


  /* image uplaod */
  const fileTypes = [
    "image/apng",
    "image/bmp",
    "image/gif",
    "image/jpeg",
    "image/pjpeg",
    "image/png",
    "image/svg+xml",
    "image/tiff",
    "image/webp",
    "image/x-icon",
    "image/avif",
  ];
  function validFileType(file) {
    return fileTypes.includes(file.type);
  }

  let inputHidden = document.querySelector("#screenshoot");
  let triggerInput = document.querySelector(".selectImage");
  let imgArea = document.querySelector(".imgArea");

  triggerInput.addEventListener("click",function(){
    inputHidden.click();
  })

  inputHidden.addEventListener("change",function(e){
    let image = e.target.files[0];
    if(!validFileType(image)){
      alert("invalid file type");
      return;
    }
    if(image.size > 2097152){
      alert("image size must be less than 2MB");
      return;
    }else{
      const reader = new FileReader();
      reader.addEventListener("load",function(){
        const allImgs = document.querySelectorAll(".imgArea img");
        allImgs.forEach((img) => {
          img.remove();
        })
        const imgUrl = reader.result;
        const img = document.createElement("img");
        img.src = imgUrl;
        imgArea.appendChild(img);
        imgArea.classList.add("active");
        imgArea.dataset.title = image.name;
      })
      reader.readAsDataURL(image);
    }
  })

</script>