let submitButton = document.getElementsByClassName("submitButton");
let cartButton = document.getElementById("cart-button");
let cartDropdown = document.getElementById("cart-dropdown");
let dropdownToggler = false;

// excute get cart data function -----------------------------------------------------------------------------

getCartDataOfSession();

// add event listener to toggle cart button -----------------------------------------------------------------------------

cartButton.addEventListener("click", () => {
  dropdownToggler = !dropdownToggler;
  if (dropdownToggler) {
    $("#cart-dropdown").css({ display: "block" });
  } else {
    $("#cart-dropdown").css({ display: "none" });
  }
});

// add event listener to decrease and increase buttons -----------------------------------------------------------------------------

cartDropdown.addEventListener("click", (e) => {
  // increase button -----------------------------------------------------------------------------

  if (
    e.target.classList.contains("increase-button") ||
    e.target.classList.contains("fa-plus")
  ) {
    let target = e.target;
    if (target.classList.contains("fa-plus")) {
      target = e.target.parentElement;
    }

    $(target)
      .siblings("input")
      .val(function (i, oldval) {
        return ++oldval;
      });
    let count = $(target).siblings("input").val();

    ajaxReq("POST", "controllers/add-element-to-cart.php", {
      productToChangeCount: $(target).data("id"),
      count: count,
    });
  }

  // increase button -----------------------------------------------------------------------------
  else if (
    e.target.classList.contains("decrease-button") ||
    e.target.classList.contains("fa-minus")
  ) {
    let target = e.target;
    if (target.classList.contains("fa-minus")) {
      target = e.target.parentElement;
    }
    if (target.disabled) {
      return;
    }
    $(target)
      .siblings("input")
      .val(function (i, oldval) {
        return --oldval;
      });
    let count = $(target).siblings("input").val();

    if (count == 0) {
      target.disabled = true;
    }

    ajaxReq(
      "POST",
      "controllers/add-element-to-cart.php",
      {
        productToChangeCount: $(target).data("id"),
        count: count,
      },
      (data) => {
        loadCartProducts(data);
      }
    );
  }
});

// add event listener to add product to cart button -----------------------------------------------------------------------------

Array.from(submitButton).forEach((element) => {
  element.addEventListener("click", () => {
    addProductToCart($(element).data("id"));
  });
});

// declare get cart data function -----------------------------------------------------------------------------

function getCartDataOfSession() {
  ajaxReq("GET", "controllers/get-cart-elements.php", {}, (data) => {
    loadCartProducts(data);
  });
}

// declare add Product To Cart function -----------------------------------------------------------------------------

function addProductToCart(productId) {
  ajaxReq(
    "POST",
    "controllers/add-element-to-cart.php",
    { hashed_id: productId },
    (product) => {
      let cartProduct = document.getElementsByClassName("cart-product")[0];
      let cartDropdown = document.getElementById("cart-dropdown");
      let productWrapper = cartProduct.cloneNode(true);
      let productImg = productWrapper.getElementsByClassName(
        "cart-product-img"
      )[0];
      productImg.src = product["product_image"];
      let productTitle = productWrapper.getElementsByClassName(
        "cart-product-title"
      )[0];
      productTitle.innerText = product["product_name"];
      let productPrice = productWrapper.getElementsByClassName(
        "cart-product-price"
      )[0];
      productPrice.innerText = product["product_price"] + " $";
      let productCount = productWrapper.getElementsByClassName(
        "count-input"
      )[0];
      productCount.value = product["count"];
      $(productWrapper)
        .find(".increase-button")
        .data("id", product["product_id"]);
      $(productWrapper)
        .find(".decrease-button")
        .data("id", product["product_id"]);
      cartDropdown.appendChild(productWrapper);
      productWrapper.style.display = "flex";
    }
  );
}

function loadCartProducts(data) {
  document.getElementsByClassName("cart-product")[0].style.display = "flex";
  let cartProduct = document
    .getElementsByClassName("cart-product")[0]
    .cloneNode(true);
  let cartDropdown = document.getElementById("cart-dropdown");
  Array.from(document.getElementsByClassName("cart-product")).forEach((el) => {
    el.style.display = "none";
  });
  data.forEach((product) => {
    console.log(product);
    console.log(cartProduct);

    let productWrapper = cartProduct.cloneNode(true);
    let productImg = productWrapper.getElementsByClassName(
      "cart-product-img"
    )[0];
    productImg.src = product["product_image"];

    let productTitle = productWrapper.getElementsByClassName(
      "cart-product-title"
    )[0];
    productTitle.innerText = product["product_name"];

    let productPrice = productWrapper.getElementsByClassName(
      "cart-product-price"
    )[0];
    productPrice.innerText = product["product_price"] + " $";

    let productCount = productWrapper.getElementsByClassName("count-input")[0];

    productCount.value = product["count"];
    $(productWrapper)
      .find(".increase-button")
      .data("id", product["product_id"]);

    $(productWrapper)
      .find(".decrease-button")
      .data("id", product["product_id"]);

    cartDropdown.appendChild(productWrapper);
  });
  document.getElementsByClassName("cart-product")[0].style.display = "none";
}
// declare ajax function -----------------------------------------------------------------------------

function ajaxReq(method, url, data, callback) {
  $.ajax({
    type: method,
    url: url,
    data: data,
    success: function (data) {
      if (data) {
        let res = JSON.parse(data);
        if (res.success) {
          callback(res.data);
        } else {
          alert(res.message);
        }
      }
    },
    error: function (err) {},
  });
}
