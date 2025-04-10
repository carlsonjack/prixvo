// adds vertical tab css
jQuery(document).ready(function ($) {
  /* add lot tabs changed with scroll, click, next and prev buttons */
  function getDivOffset(divId) {
    const divElement = document.getElementById(divId);
    const rect = divElement.getBoundingClientRect();
    return rect.height;
  }

  const divOffsets = [];
  let activeTab = 1;
  const $scrollableDiv = $(".lot-main");
  const $children = $scrollableDiv.children();

  $children.each(function (index) {
    const $child = $(this);
    const activeState = index === 0;
    const id = $child.attr("id");
    const subDiv = {
      id: id,
      size: getDivOffset(id),
      active: activeState,
    };
    divOffsets.push(subDiv);
  });

  let clicked = "";
  $("#tabs-list ul li").click(function () {
    if (activeTab === 1) {
      activeTab = $(this).index() + 1;
    }
    clicked = activeTab;
    const tabId = $(this).find("a").attr("data-tab-id");
    const mainContainer = $(".lot-main");
    const targetDiv = $('.lot-main div[id="' + tabId + '"]');
    const scrollToPosition =
      targetDiv.offset().top -
      mainContainer.offset().top +
      mainContainer.scrollTop();
    mainContainer.scrollTop(scrollToPosition);
    if (activeTab === 1) {
      $("#tabs-list ul li:nth-child(" + activeTab + ") a")
        .parent("li")
        .addClass("ui-tabs-active")
        .siblings()
        .removeClass("ui-tabs-active");
    }
    tabChanged();
  });

  $("#tabs-list ul li:first-child").click();

  $scrollableDiv.scroll(function () {
    const scrollTop = $scrollableDiv.scrollTop();
    let activeId = 0;
    let totalscrolled = 0;
    if (scrollTop >= 0 && scrollTop < divOffsets[0].size) {
      activeTab = 1;
    }
    for (const [key, value] of Object.entries(divOffsets)) {
      totalscrolled += value.size;
      if (totalscrolled <= scrollTop + 100) {
        activeId = parseInt(key);
        activeTab = parseInt(key) + 2;
        divOffsets[key].active = true;
      } else {
        divOffsets[key].active = false;
      }
    }
    if (clicked !== "") {
      activeTab = clicked;
    }
    $("#tabs-list ul li:nth-child(" + activeTab + ") a")
      .parent("li")
      .addClass("ui-tabs-active")
      .siblings()
      .removeClass("ui-tabs-active");
    tabChanged();
    activeTab = 1;
    totalscrolled = 0;
    clicked = "";
  });

  function tabChanged() {
    updatePreview();
    const tabs = $("#tabs-list ul");
    const activetab = $("#tabs-list ul li.ui-tabs-active");
    const selected = activetab.index();

    if (selected === 0) {
      jQuery(".prev-tab").hide();
    } else {
      jQuery(".prev-tab").show();
    }

    if (selected + 1 === tabs.find("li").length) {
      jQuery(".next-tab").hide();
      jQuery(".add-auction-input").show();
    } else {
      jQuery(".next-tab").show();
      jQuery(".add-auction-input").hide();
    }
  }

  function tabChangeClicked(type = "prev") {
    const activetab_ = $("#tabs-list ul li.ui-tabs-active");
    if (type === "prev") {
      activetab_.prev().click();
    } else {
      activetab_.next().click();
    }
  }

  jQuery(".next-tab").click(function (e) {
    e.preventDefault();
    tabChangeClicked("next");
  });

  jQuery(".prev-tab").click(function (e) {
    e.preventDefault();
    tabChangeClicked("prev");
  });

  setTimeout(function () {
    jQuery("#messageBox").hide("blind", {}, 500);
  }, 5000);
  // Define the function that shows/hides the seller-reserve-box
  function toggleSellerReserveBox() {
    if (jQuery(".seller-reserve-check").is(":checked")) {
      jQuery(".seller-reserve-box").show();
    } else {
      jQuery(".seller-reserve-box").hide();
    }
  }

  // Call the function once on page load
  toggleSellerReserveBox();

  // Listen for changes to the checkbox and call the function
  jQuery(".seller-reserve-check").change(toggleSellerReserveBox);
  $(document).on("input", "#_regular_price", function (e) {
    let retail_price = $(this).val();
    let buy_now_checkbox = $("input[name='uwa_auction_selling_type_buyitnow']");
    if (retail_price != "") {
      buy_now_checkbox.val("on");
    } else {
      buy_now_checkbox.val("off");
    }
  });
  $("#_regular_price").trigger("input");

  function imageDivHtml(index, url, name, id) {
    let imageBoxCount = $("#gallery_images_show .item-block").length;
    let main = "draggable";
    if (index == 0 && imageBoxCount == 0) {
      main = "main droppable";
    }

    let html = '<div class="item-block ' + main + ' " >';
    html +=
      '<img class="uploaded-img" src="' + url + '" data-img-id="' + id + '"/>';
    html += ' <div class="img-block-foot">';
    html += '<div class="image-text">' + name + "</div>";
    html +=
      '<a href="#" class="delete-icon"><img src="' +
      add_auction_data.delete_image +
      '" /> </a>';
    html += "</div>";
    html += "</div>";
    return html;
  }






  var frame;
  var selectedMediaIds = add_auction_data.selectedMediaIds;
  var interior_selectedMediaIds = add_auction_data.interior_selectedMediaIds;
  var mechanical_selectedMediaIds = add_auction_data.mechanical_selectedMediaIds;
  var other_selectedMediaIds = add_auction_data.other_selectedMediaIds;
  var docs_selectedMediaIds = add_auction_data.docs_selectedMediaIds;
  
  var imageUploadModeType = add_auction_data.imageUploadMode;
  var imagecontainter = $("#gallery_images_show .grid-container");
  var interior_images_show = $("#interior_images_show .grid-container");
  var mechanical_images_show = $("#mechanical_images_show .grid-container");
  var other_images_show = $("#other_images_show .grid-container");
  var docs_images_show = $("#docs_images_show .grid-container");

  


  $("div.gallery-box").hide();
  $("div.interior_images_gallery-box").hide();
  $("div.mechanical_images_gallery-box").hide();
  $("div.other_images_gallery-box").hide();
  $("div.docs_images_gallery-box").hide();

 /* Interioe images */ 
 $("#interior_images").on("click", function (e) {
  if (imageUploadModeType == "media_gallery") {
    e.preventDefault();
    if (frame) {
      frame.open();
      return;
    }
    frame = wp.media({
      author: add_auction_data.user_id,
      multiple: true, // Allow multiple image selection
      library: {
        type: "image", // Only show images in the media library
      },
    });
    // Pre-select previously selected media items
    frame.on("open", function () {
      var selection = frame.state().get("selection");
      // Get the previously selected media IDs
      interior_selectedMediaIds.forEach(function (attachment) {
        var mediaId = attachment.id;
        var attachment = wp.media.attachment(mediaId);
        attachment.fetch();
        selection.add(attachment ? [attachment] : []);
      });
    });

    frame.on("select", function () {
      Interior_selectedMediaIds = frame.state().get("selection").toJSON();
      enableSortable();
    });

    frame.open();
  }
});


$("#interior_images").on("change", function (event) {
  if (imageUploadModeType != "media_gallery") {
    var files = event.target.files;
    var userId = add_auction_data.user_id; // Replace with the actual user ID
    handleFileUpload_interior_images(files, userId);
  }
});

function handleFileUpload_interior_images(files, userId) {
  // Create a FormData object to store the files and other data
  var formData = new FormData();
  for (var i = 0; i < files.length; i++) {
    formData.append("image[]", files[i]);
  }
  formData.append("action", "upload_image");
  formData.append("user_id", userId);
  $("#interior_images_upload_message").hide();
  // Make an AJAX request
  $.ajax({
    url: ajaxurl, // The WordPress AJAX URL
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    beforeSend: function (xhr) {
      $("#interior_images_loader_ajax").show();
      $("#interior_images_upload_message").html(add_auction_data.upload_proccessing_msg);
      $("#interior_images_upload_message").show();
      $(".interior_images_gallery_upload_box").hide();
    },
    success: function (response) {
      var attachmentData = JSON.parse(response);
      if (attachmentData.success) {
        var attachments = attachmentData.files;
        if (interior_selectedMediaIds.length === 0) {
          interior_selectedMediaIds = attachments;
        } else {
          interior_selectedMediaIds = interior_selectedMediaIds.concat(attachments);
        }
        interior_selecte_enableSortable();
        $("#interior_images_upload_message").html(add_auction_data.upload_success_msg);
      } else {
        $("#interior_images_upload_message").html(add_auction_data.upload_failed_msg);
        $("#interior_images_upload_message").show();
      }
    },
    error: function (xhr, status, error) {
      $("#interior_images_upload_message").addClass("upload_message_red");
      $("#interior_images_upload_message").html(add_auction_data.upload_failed_msg);
    },
    complete: function (xhr, status, error) {
      $("#interior_images_loader_ajax").hide();
      $("#interior_images_upload_message").hide();
    },
  });
}


$(document).on("click", "#interior_images_addByComputer", function (e) {
  //alert('hi');
  e.preventDefault();
  $("#interior_images").click();
});
$(document).on(
  "click",
  "#interior_images_show .item-block .delete-icon",
  function (e) {
    e.preventDefault();
    let removeBlock = $(this).closest(".item-block");
    let id = removeBlock.find("img").attr("data-img-id");
    var newinterior_selectedMediaIds = interior_selectedMediaIds.filter(function (obj) {
      return obj.id != id;
    });
    interior_selectedMediaIds = newinterior_selectedMediaIds;
    interior_selecte_enableSortable();
  }
);
$(document).on("click", "#interior_selecte_deleteImages", function (e) {
  e.preventDefault();
  interior_selectedMediaIds = [];
  interior_selecte_enableSortable();
});
interior_selecte_enableSortable();
function interior_selecte_enableSortable() {
  
  let imageBoxes = $("#interior_images_show .item-block");
  let imageBoxCount = imageBoxes.length;
  if (interior_selectedMediaIds.length == 0) {
    $(".interior_images_gallery-box").hide();
    $("#interior_images_upload_message").hide();
    $(".interior_images_gallery_upload_box").show();
    $("#interior_images_loader_ajax").hide();
    interior_selectedMediaIds = [];
    return false;
  }
  let i = 0;
  let interior_images_gallery_images_url_collection = [];
  let interior_images_gallery_images_ids_collection = [];
  let finaImagesHtml = "";
  var childElements = interior_images_show.children().not(":first");
  childElements.remove();
  interior_selectedMediaIds.forEach(function (attachment) {
    var imageId = attachment.id;
    var imageUrl = attachment.url;
    var imageName = attachment.filename;
    finaImagesHtml += imageDivHtml(i, imageUrl, imageName, imageId);
    interior_images_gallery_images_url_collection.push(imageUrl);
    interior_images_gallery_images_ids_collection.push(imageId);
    i++;
  });
  //alert(interior_images_gallery_images_ids_collection);
  interior_images_show.append(finaImagesHtml);
  if (interior_images_gallery_images_url_collection.length > 0) {
    $("#interior_images_url").val(interior_images_gallery_images_url_collection.join(","));
    $("#interior_images_ids").val(interior_images_gallery_images_ids_collection.join(","));
  }
  $(".interior_images_gallery_upload_box").hide();
  // Enable drag and drop functionality
  $(".interior_images_gallery-box").show();
  $(".draggable").draggable({
    revert: "invalid",
  });
  $(".droppable").droppable({
    accept: ".draggable",
    drop: function (event, ui) {
      var draggedElement = ui.draggable;
      var droppedElement = $(this);

      // Get the content of the dragged and dropped elements
      var draggedContent = draggedElement.html();
      var droppedContent = droppedElement.html();

      // Swap the contents between dragged and dropped elements
      draggedElement.html(droppedContent);
      droppedElement.html(draggedContent);
      draggedElement.css({
        right: "",
        bottom: "",
        top: "",
        left: "",
      });
      // Remove droppable class from the dragged element
      draggedElement.removeClass("droppable");
      interior_images_updatePreview();
    },
  });
  // updatePreview()

  init();
}

/* END interior */ 



/* mechanical images */ 
$("#mechanical_images").on("click", function (e) {
  if (imageUploadModeType == "media_gallery") {
    e.preventDefault();
    if (frame) {
      frame.open();
      return;
    }
    frame = wp.media({
      author: add_auction_data.user_id,
      multiple: true, // Allow multiple image selection
      library: {
        type: "image", // Only show images in the media library
      },
    });
    // Pre-select previously selected media items
    frame.on("open", function () {
      var selection = frame.state().get("selection");
      // Get the previously selected media IDs
      mechanical_selectedMediaIds.forEach(function (attachment) {
        var mediaId = attachment.id;
        var attachment = wp.media.attachment(mediaId);
        attachment.fetch();
        selection.add(attachment ? [attachment] : []);
      });
    });

    frame.on("select", function () {
      mechanical_selectedMediaIds = frame.state().get("selection").toJSON();
      enableSortable();
    });

    frame.open();
  }
});


$("#mechanical_images").on("change", function (event) {
  if (imageUploadModeType != "media_gallery") {
    var files = event.target.files;
    var userId = add_auction_data.user_id; // Replace with the actual user ID
    handleFileUpload_mechanical_images(files, userId);
  }
});

function handleFileUpload_mechanical_images(files, userId) {
  // Create a FormData object to store the files and other data
  var formData = new FormData();
  for (var i = 0; i < files.length; i++) {
    formData.append("image[]", files[i]);
  }
  formData.append("action", "upload_image");
  formData.append("user_id", userId);
  $("#mechanical_images_upload_message").hide();
  // Make an AJAX request
  $.ajax({
    url: ajaxurl, // The WordPress AJAX URL
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    beforeSend: function (xhr) {
      $("#mechanical_images_loader_ajax").show();
      $("#mechanical_images_upload_message").html(add_auction_data.upload_proccessing_msg);
      $("#mechanical_images_upload_message").show();
      $(".mechanical_images_gallery_upload_box").hide();
    },
    success: function (response) {
      var attachmentData = JSON.parse(response);
      if (attachmentData.success) {
        var attachments = attachmentData.files;
        if (mechanical_selectedMediaIds.length === 0) {
          mechanical_selectedMediaIds = attachments;
        } else {
          mechanical_selectedMediaIds = mechanical_selectedMediaIds.concat(attachments);
        }
        mechanical_selecte_enableSortable();
        $("#mechanical_images_upload_message").html(add_auction_data.upload_success_msg);
      } else {
        $("#mechanical_images_upload_message").html(add_auction_data.upload_failed_msg);
        $("#mechanical_images_upload_message").show();
      }
    },
    error: function (xhr, status, error) {
      $("#mechanical_images_upload_message").addClass("upload_message_red");
      $("#mechanical_images_upload_message").html(add_auction_data.upload_failed_msg);
    },
    complete: function (xhr, status, error) {
      $("#mechanical_images_loader_ajax").hide();
      $("#mechanical_images_upload_message").hide();
    },
  });
}


$(document).on("click", "#mechanical_images_addByComputer", function (e) {
  //alert('hi');
  e.preventDefault();
  $("#mechanical_images").click();
});
$(document).on(
  "click",
  "#mechanical_images_show .item-block .delete-icon",
  function (e) {
    e.preventDefault();
    let removeBlock = $(this).closest(".item-block");
    let id = removeBlock.find("img").attr("data-img-id");
    var newmechanical_selectedMediaIds = mechanical_selectedMediaIds.filter(function (obj) {
      return obj.id != id;
    });
    mechanical_selectedMediaIds = newmechanical_selectedMediaIds;
    mechanical_selecte_enableSortable();
  }
);
$(document).on("click", "#mechanical_selecte_deleteImages", function (e) {
  e.preventDefault();
  mechanical_selectedMediaIds = [];
  mechanical_selecte_enableSortable();
});
mechanical_selecte_enableSortable();
function mechanical_selecte_enableSortable() {
  
  let imageBoxes = $("#mechanical_images_show .item-block");
  let imageBoxCount = imageBoxes.length;
  if (mechanical_selectedMediaIds.length == 0) {
    $(".mechanical_images_gallery-box").hide();
    $("#mechanical_images_upload_message").hide();
    $(".mechanical_images_gallery_upload_box").show();
    $("#mechanical_images_loader_ajax").hide();
    mechanical_selectedMediaIds = [];
    return false;
  }
  let i = 0;
  let mechanical_images_gallery_images_url_collection = [];
  let mechanical_images_gallery_images_ids_collection = [];
  let finaImagesHtml = "";
  var childElements = mechanical_images_show.children().not(":first");
  childElements.remove();
  mechanical_selectedMediaIds.forEach(function (attachment) {
    var imageId = attachment.id;
    var imageUrl = attachment.url;
    var imageName = attachment.filename;
    finaImagesHtml += imageDivHtml(i, imageUrl, imageName, imageId);
    mechanical_images_gallery_images_url_collection.push(imageUrl);
    mechanical_images_gallery_images_ids_collection.push(imageId);
    i++;
  });
  //alert(mechanical_images_gallery_images_ids_collection);
  mechanical_images_show.append(finaImagesHtml);
  if (mechanical_images_gallery_images_url_collection.length > 0) {
    $("#mechanical_images_url").val(mechanical_images_gallery_images_url_collection.join(","));
    $("#mechanical_images_ids").val(mechanical_images_gallery_images_ids_collection.join(","));
  }
  $(".mechanical_images_gallery_upload_box").hide();
  // Enable drag and drop functionality
  $(".mechanical_images_gallery-box").show();
  $(".draggable").draggable({
    revert: "invalid",
  });
  $(".droppable").droppable({
    accept: ".draggable",
    drop: function (event, ui) {
      var draggedElement = ui.draggable;
      var droppedElement = $(this);

      // Get the content of the dragged and dropped elements
      var draggedContent = draggedElement.html();
      var droppedContent = droppedElement.html();

      // Swap the contents between dragged and dropped elements
      draggedElement.html(droppedContent);
      droppedElement.html(draggedContent);
      draggedElement.css({
        right: "",
        bottom: "",
        top: "",
        left: "",
      });
      // Remove droppable class from the dragged element
      draggedElement.removeClass("droppable");
      mechanical_images_updatePreview();
    },
  });
  // updatePreview()

  init();
}

/* END mechanical */ 

/* other images */ 
$("#other_images").on("click", function (e) {
  if (imageUploadModeType == "media_gallery") {
    e.preventDefault();
    if (frame) {
      frame.open();
      return;
    }
    frame = wp.media({
      author: add_auction_data.user_id,
      multiple: true, // Allow multiple image selection
      library: {
        type: "image", // Only show images in the media library
      },
    });
    // Pre-select previously selected media items
    frame.on("open", function () {
      var selection = frame.state().get("selection");
      // Get the previously selected media IDs
      other_selectedMediaIds.forEach(function (attachment) {
        var mediaId = attachment.id;
        var attachment = wp.media.attachment(mediaId);
        attachment.fetch();
        selection.add(attachment ? [attachment] : []);
      });
    });

    frame.on("select", function () {
      other_selectedMediaIds = frame.state().get("selection").toJSON();
      enableSortable();
    });

    frame.open();
  }
});


$("#other_images").on("change", function (event) {
  if (imageUploadModeType != "media_gallery") {
    var files = event.target.files;
    var userId = add_auction_data.user_id; // Replace with the actual user ID
    handleFileUpload_other_images(files, userId);
  }
});

function handleFileUpload_other_images(files, userId) {
  // Create a FormData object to store the files and other data
  var formData = new FormData();
  for (var i = 0; i < files.length; i++) {
    formData.append("image[]", files[i]);
  }
  formData.append("action", "upload_image");
  formData.append("user_id", userId);
  $("#other_images_upload_message").hide();
  // Make an AJAX request
  $.ajax({
    url: ajaxurl, // The WordPress AJAX URL
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    beforeSend: function (xhr) {
      $("#other_images_loader_ajax").show();
      $("#other_images_upload_message").html(add_auction_data.upload_proccessing_msg);
      $("#other_images_upload_message").show();
      $(".other_images_gallery_upload_box").hide();
    },
    success: function (response) {
      var attachmentData = JSON.parse(response);
      if (attachmentData.success) {
        var attachments = attachmentData.files;
        if (other_selectedMediaIds.length === 0) {
          other_selectedMediaIds = attachments;
        } else {
          other_selectedMediaIds = other_selectedMediaIds.concat(attachments);
        }
        other_selecte_enableSortable();
        $("#other_images_upload_message").html(add_auction_data.upload_success_msg);
      } else {
        $("#other_images_upload_message").html(add_auction_data.upload_failed_msg);
        $("#other_images_upload_message").show();
      }
    },
    error: function (xhr, status, error) {
      $("#other_images_upload_message").addClass("upload_message_red");
      $("#other_images_upload_message").html(add_auction_data.upload_failed_msg);
    },
    complete: function (xhr, status, error) {
      $("#other_images_loader_ajax").hide();
      $("#other_images_upload_message").hide();
    },
  });
}


$(document).on("click", "#other_images_addByComputer", function (e) {
  //alert('hi');
  e.preventDefault();
  $("#other_images").click();
});
$(document).on(
  "click",
  "#other_images_show .item-block .delete-icon",
  function (e) {
    e.preventDefault();
    let removeBlock = $(this).closest(".item-block");
    let id = removeBlock.find("img").attr("data-img-id");
    var newother_selectedMediaIds = other_selectedMediaIds.filter(function (obj) {
      return obj.id != id;
    });
    other_selectedMediaIds = newother_selectedMediaIds;
    other_selecte_enableSortable();
  }
);
$(document).on("click", "#other_selecte_deleteImages", function (e) {
  e.preventDefault();
  other_selectedMediaIds = [];
  other_selecte_enableSortable();
});
other_selecte_enableSortable();
function other_selecte_enableSortable() {
  
  let imageBoxes = $("#other_images_show .item-block");
  let imageBoxCount = imageBoxes.length;
  if (other_selectedMediaIds.length == 0) {
    $(".other_images_gallery-box").hide();
    $("#other_images_upload_message").hide();
    $(".other_images_gallery_upload_box").show();
    $("#other_images_loader_ajax").hide();
    other_selectedMediaIds = [];
    return false;
  }
  let i = 0;
  let other_images_gallery_images_url_collection = [];
  let other_images_gallery_images_ids_collection = [];
  let finaImagesHtml = "";
  var childElements = other_images_show.children().not(":first");
  childElements.remove();
  other_selectedMediaIds.forEach(function (attachment) {
    var imageId = attachment.id;
    var imageUrl = attachment.url;
    var imageName = attachment.filename;
    finaImagesHtml += imageDivHtml(i, imageUrl, imageName, imageId);
    other_images_gallery_images_url_collection.push(imageUrl);
    other_images_gallery_images_ids_collection.push(imageId);
    i++;
  });
  //alert(other_images_gallery_images_ids_collection);
  other_images_show.append(finaImagesHtml);
  if (other_images_gallery_images_url_collection.length > 0) {
    $("#other_images_url").val(other_images_gallery_images_url_collection.join(","));
    $("#other_images_ids").val(other_images_gallery_images_ids_collection.join(","));
  }
  $(".other_images_gallery_upload_box").hide();
  // Enable drag and drop functionality
  $(".other_images_gallery-box").show();
  $(".draggable").draggable({
    revert: "invalid",
  });
  $(".droppable").droppable({
    accept: ".draggable",
    drop: function (event, ui) {
      var draggedElement = ui.draggable;
      var droppedElement = $(this);

      // Get the content of the dragged and dropped elements
      var draggedContent = draggedElement.html();
      var droppedContent = droppedElement.html();

      // Swap the contents between dragged and dropped elements
      draggedElement.html(droppedContent);
      droppedElement.html(draggedContent);
      draggedElement.css({
        right: "",
        bottom: "",
        top: "",
        left: "",
      });
      // Remove droppable class from the dragged element
      draggedElement.removeClass("droppable");
      other_images_updatePreview();
    },
  });
  // updatePreview()

  init();
}

/* END other */ 
/* docs images */ 
$("#docs_images").on("click", function (e) {
  if (imageUploadModeType == "media_gallery") {
    e.preventDefault();
    if (frame) {
      frame.open();
      return;
    }
    frame = wp.media({
      author: add_auction_data.user_id,
      multiple: true, // Allow multiple image selection
      library: {
        type: "image", // Only show images in the media library
      },
    });
    // Pre-select previously selected media items
    frame.on("open", function () {
      var selection = frame.state().get("selection");
      // Get the previously selected media IDs
      docs_selectedMediaIds.forEach(function (attachment) {
        var mediaId = attachment.id;
        var attachment = wp.media.attachment(mediaId);
        attachment.fetch();
        selection.add(attachment ? [attachment] : []);
      });
    });

    frame.on("select", function () {
      docs_selectedMediaIds = frame.state().get("selection").toJSON();
      enableSortable();
    });

    frame.open();
  }
});


$("#docs_images").on("change", function (event) {
  if (imageUploadModeType != "media_gallery") {
    var files = event.target.files;
    var userId = add_auction_data.user_id; // Replace with the actual user ID
    handleFileUpload_docs_images(files, userId);
  }
});

function handleFileUpload_docs_images(files, userId) {
  // Create a FormData object to store the files and docs data
  var formData = new FormData();
  for (var i = 0; i < files.length; i++) {
    formData.append("image[]", files[i]);
  }
  formData.append("action", "upload_image");
  formData.append("user_id", userId);
  $("#docs_images_upload_message").hide();
  // Make an AJAX request
  $.ajax({
    url: ajaxurl, // The WordPress AJAX URL
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    beforeSend: function (xhr) {
      $("#docs_images_loader_ajax").show();
      $("#docs_images_upload_message").html(add_auction_data.upload_proccessing_msg);
      $("#docs_images_upload_message").show();
      $(".docs_images_gallery_upload_box").hide();
    },
    success: function (response) {
      var attachmentData = JSON.parse(response);
      if (attachmentData.success) {
        var attachments = attachmentData.files;
        if (docs_selectedMediaIds.length === 0) {
          docs_selectedMediaIds = attachments;
        } else {
          docs_selectedMediaIds = docs_selectedMediaIds.concat(attachments);
        }
        docs_selecte_enableSortable();
        $("#docs_images_upload_message").html(add_auction_data.upload_success_msg);
      } else {
        $("#docs_images_upload_message").html(add_auction_data.upload_failed_msg);
        $("#docs_images_upload_message").show();
      }
    },
    error: function (xhr, status, error) {
      $("#docs_images_upload_message").addClass("upload_message_red");
      $("#docs_images_upload_message").html(add_auction_data.upload_failed_msg);
    },
    complete: function (xhr, status, error) {
      $("#docs_images_loader_ajax").hide();
      $("#docs_images_upload_message").hide();
    },
  });
}


$(document).on("click", "#docs_images_addByComputer", function (e) {
  //alert('hi');
  e.preventDefault();
  $("#docs_images").click();
});
$(document).on(
  "click",
  "#docs_images_show .item-block .delete-icon",
  function (e) {
    e.preventDefault();
    let removeBlock = $(this).closest(".item-block");
    let id = removeBlock.find("img").attr("data-img-id");
    var newdocs_selectedMediaIds = docs_selectedMediaIds.filter(function (obj) {
      return obj.id != id;
    });
    docs_selectedMediaIds = newdocs_selectedMediaIds;
    docs_selecte_enableSortable();
  }
);
$(document).on("click", "#docs_selecte_deleteImages", function (e) {
  e.preventDefault();
  docs_selectedMediaIds = [];
  docs_selecte_enableSortable();
});
docs_selecte_enableSortable();
function docs_selecte_enableSortable() {
  
  let imageBoxes = $("#docs_images_show .item-block");
  let imageBoxCount = imageBoxes.length;
  if (docs_selectedMediaIds.length == 0) {
    $(".docs_images_gallery-box").hide();
    $("#docs_images_upload_message").hide();
    $(".docs_images_gallery_upload_box").show();
    $("#docs_images_loader_ajax").hide();
    docs_selectedMediaIds = [];
    return false;
  }
  let i = 0;
  let docs_images_gallery_images_url_collection = [];
  let docs_images_gallery_images_ids_collection = [];
  let finaImagesHtml = "";
  var childElements = docs_images_show.children().not(":first");
  childElements.remove();
  docs_selectedMediaIds.forEach(function (attachment) {
    var imageId = attachment.id;
    var imageUrl = attachment.url;
    var imageName = attachment.filename;
    finaImagesHtml += imageDivHtml(i, imageUrl, imageName, imageId);
    docs_images_gallery_images_url_collection.push(imageUrl);
    docs_images_gallery_images_ids_collection.push(imageId);
    i++;
  });
  //alert(docs_images_gallery_images_ids_collection);
  docs_images_show.append(finaImagesHtml);
  if (docs_images_gallery_images_url_collection.length > 0) {
    $("#docs_images_url").val(docs_images_gallery_images_url_collection.join(","));
    $("#docs_images_ids").val(docs_images_gallery_images_ids_collection.join(","));
  }
  $(".docs_images_gallery_upload_box").hide();
  // Enable drag and drop functionality
  $(".docs_images_gallery-box").show();
  $(".draggable").draggable({
    revert: "invalid",
  });
  $(".droppable").droppable({
    accept: ".draggable",
    drop: function (event, ui) {
      var draggedElement = ui.draggable;
      var droppedElement = $(this);

      // Get the content of the dragged and dropped elements
      var draggedContent = draggedElement.html();
      var droppedContent = droppedElement.html();

      // Swap the contents between dragged and dropped elements
      draggedElement.html(droppedContent);
      droppedElement.html(draggedContent);
      draggedElement.css({
        right: "",
        bottom: "",
        top: "",
        left: "",
      });
      // Remove droppable class from the dragged element
      draggedElement.removeClass("droppable");
      docs_images_updatePreview();
    },
  });
  // updatePreview()

  init();
}

/* END docs */ 
  // Open media uploader on click
  $("#gallery_images").on("click", function (e) {
    if (imageUploadModeType == "media_gallery") {
      e.preventDefault();
      if (frame) {
        frame.open();
        return;
      }
      frame = wp.media({
        // title: 'Select or Upload Images',
        // button: {
        //     text: 'Use this Image'
        // },
        author: add_auction_data.user_id,
        multiple: true, // Allow multiple image selection
        library: {
          type: "image", // Only show images in the media library
        },
      });
      // Pre-select previously selected media items
      frame.on("open", function () {
        var selection = frame.state().get("selection");
        // Get the previously selected media IDs
        selectedMediaIds.forEach(function (attachment) {
          var mediaId = attachment.id;
          var attachment = wp.media.attachment(mediaId);
          attachment.fetch();
          selection.add(attachment ? [attachment] : []);
        });
      });

      frame.on("select", function () {
        selectedMediaIds = frame.state().get("selection").toJSON();
        enableSortable();
      });

      frame.open();
    }
  });
  $("#gallery_images").on("change", function (event) {
    if (imageUploadModeType != "media_gallery") {
      var files = event.target.files;
      var userId = add_auction_data.user_id; // Replace with the actual user ID
      handleFileUpload(files, userId);
    }
  });

  function handleFileUpload(files, userId) {
    // Create a FormData object to store the files and other data
    var formData = new FormData();
    for (var i = 0; i < files.length; i++) {
      formData.append("image[]", files[i]);
    }
    formData.append("action", "upload_image");
    formData.append("user_id", userId);
    $("#upload_message").hide();
    // Make an AJAX request
    $.ajax({
      url: ajaxurl, // The WordPress AJAX URL
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: function (xhr) {
        $("#loader_ajax").show();
        $("#upload_message").html(add_auction_data.upload_proccessing_msg);
        $("#upload_message").show();
        $(".gallery_upload_box").hide();
      },
      success: function (response) {
        var attachmentData = JSON.parse(response);
        if (attachmentData.success) {
          var attachments = attachmentData.files;
          if (selectedMediaIds.length === 0) {
            selectedMediaIds = attachments;
          } else {
            selectedMediaIds = selectedMediaIds.concat(attachments);
          }
          enableSortable();
          $("#upload_message").html(add_auction_data.upload_success_msg);
        } else {
          $("#upload_message").html(add_auction_data.upload_failed_msg);
          $("#upload_message").show();
        }
      },
      error: function (xhr, status, error) {
        $("#upload_message").addClass("upload_message_red");
        $("#upload_message").html(add_auction_data.upload_failed_msg);
      },
      complete: function (xhr, status, error) {
        $("#loader_ajax").hide();
        $("#upload_message").hide();
      },
    });
  }
  $(document).on("click", "#addByComputer", function (e) {
    e.preventDefault();
    $("#gallery_images").click();
  });
  $(document).on(
    "click",
    "#gallery_images_show .item-block .delete-icon",
    function (e) {
      e.preventDefault();
      let removeBlock = $(this).closest(".item-block");
      let id = removeBlock.find("img").attr("data-img-id");
      var newSelectedMediaIds = selectedMediaIds.filter(function (obj) {
        return obj.id != id;
      });
      selectedMediaIds = newSelectedMediaIds;
      enableSortable();
    }
  );
  $(document).on("click", "#deleteImages", function (e) {
    e.preventDefault();
    selectedMediaIds = [];
    enableSortable();
  });

  enableSortable();
  function enableSortable() {
    let imageBoxes = $("#gallery_images_show .item-block");
    let imageBoxCount = imageBoxes.length;
    if (selectedMediaIds.length == 0) {
      $(".gallery-box").hide();
      $("#upload_message").hide();
      $(".gallery_upload_box").show();
      $("#loader_ajax").hide();
      selectedMediaIds = [];
      return false;
    }
    let i = 0;
    let gallery_images_url_collection = [];
    let gallery_images_ids_collection = [];
    let finaImagesHtml = "";
    var childElements = imagecontainter.children().not(":first");
    childElements.remove();
    selectedMediaIds.forEach(function (attachment) {
      var imageId = attachment.id;
      var imageUrl = attachment.url;
      var imageName = attachment.filename;
      finaImagesHtml += imageDivHtml(i, imageUrl, imageName, imageId);
      if (i == 0) {
        $("#featured_image_url").val(imageUrl);
        $("#featured_image_id").val(imageId);
      } else {
        gallery_images_url_collection.push(imageUrl);
        gallery_images_ids_collection.push(imageId);
      }
      i++;
    });
    imagecontainter.append(finaImagesHtml);
    if (gallery_images_url_collection.length > 0) {
      $("#gallery_images_url").val(gallery_images_url_collection.join(","));
      $("#gallery_images_ids").val(gallery_images_ids_collection.join(","));
    }
    $(".gallery_upload_box").hide();
    // Enable drag and drop functionality
    $(".gallery-box").show();
    $(".draggable").draggable({
      revert: "invalid",
    });
    $(".droppable").droppable({
      accept: ".draggable",
      drop: function (event, ui) {
        var draggedElement = ui.draggable;
        var droppedElement = $(this);

        // Get the content of the dragged and dropped elements
        var draggedContent = draggedElement.html();
        var droppedContent = droppedElement.html();

        // Swap the contents between dragged and dropped elements
        draggedElement.html(droppedContent);
        droppedElement.html(draggedContent);
        draggedElement.css({
          right: "",
          bottom: "",
          top: "",
          left: "",
        });
        // Remove droppable class from the dragged element
        draggedElement.removeClass("droppable");
        updatePreview();
      },
    });
    // updatePreview()

    init();
  }

  function touchHandler(event) {
    var touch = event.changedTouches[0];
    var tImg = touch.target;
    if (tImg.classList.contains("uploaded-img")) {
      var simulatedEvent = document.createEvent("MouseEvent");
      console.log(simulatedEvent);
      simulatedEvent.initMouseEvent(
        {
          touchstart: "mousedown",
          touchmove: "mousemove",
          touchend: "mouseup",
        }[event.type],
        true,
        true,
        window,
        1,
        touch.screenX,
        touch.screenY,
        touch.clientX,
        touch.clientY,
        false,
        false,
        false,
        false,
        0,
        null
      );

      touch.target.dispatchEvent(simulatedEvent);
      event.preventDefault();
    }
  }

  function init() {
    document.addEventListener("touchstart", touchHandler, true);
    document.addEventListener("touchmove", touchHandler, true);
    document.addEventListener("touchend", touchHandler, true);
    document.addEventListener("touchcancel", touchHandler, true);
  }

  $(".p-message-success").hide();
  $(".p-message-failed").hide();



  /* Interier Images START */

  

  /* Interier Images END */



  /* all presets show and add flow */
  let allPresets;
  let select_preset = $("select[name='shipping_preset_selection']");
  let shipping_preset_type = $("input[name=shipping_preset_type]");
  $(shipping_preset_type).on("change", function (e) {
    swicthPresetType(this.checked);
  });
  swicthPresetType(false);
  function swicthPresetType(type) {
    $(".preset-message").hide();
    if (!type) {
      select_preset.show();
      $("#delete-shiping-preset").show();
      $(".preser-name").hide();
      $("#save-shiping-preset").html(add_auction_data.update_btn_text);
      $("#save-shiping-preset").attr("action-type", "update");
      getPresets(setPresets);
    } else {
      select_preset.hide();
      $("#save-shiping-preset").html(add_auction_data.save_btn_text);
      $(".preser-name").show();
      $("#delete-shiping-preset").hide();
      $("#save-shiping-preset").attr("action-type", "add-new");
      resetPresetFields();
    }
  }
  function resetPresetFields() {
    $("input[name=seller_shipping_fee_by]").prop("checked", true);
    $("input[name='local_pickup_country_price']").val("");
    $("input[name='local_pickup_continent_price']").val("");
    $("input[name='local_pickup_world_price']").val("");
    $("input[name='shipping_preset_name']").val("");
  }
  function getPresets(callback) {
    var data = {
      action: "uat_seller_sihipping_preset_get",
    };
    // Make the AJAX request
    $.ajax({
      url: ajaxurl, // The URL for the WordPress backend endpoint
      type: "POST",
      data: data,
      success: function (response) {
        allPresets = response.shipping_data;
        if(allPresets.length == 0){
          $('.shiping_preset_label').hide();
          $('.shiping_preset_options').hide();
          $('.shiping_preset_options_select').hide();
        }else{
          $('.shiping_preset_label').show();
          $('.shiping_preset_options').show();
          $('.shiping_preset_options_select').show();
        }
        callback(response.shipping_data);
      },
    });
  }
  getPresets(setPresets);
  function setPresets(shippingPresets) {
    select_preset.empty();
    if (shippingPresets) {
      $.each(shippingPresets, function (index, oneSet) {
        let value = oneSet.shipping_preset_name;
        var option = $("<option>").text(value).attr("value", value);
        select_preset.append(option);
      });
    } else {
      var option = $("<option>").text("Select preset").attr("value", "0");
      select_preset.append(option);
    }
    setSelectedPreset(shippingPresets);
  }
  function setSelectedPreset(shippingPresets) {
    resetPresetFields();

    // Set the name of the shipping preset you want to find
    var selectedName = select_preset.val();
    if (!jQuery.isEmptyObject(shippingPresets)) {
      shipping_preset_type.prop("disabled", false);
      shipping_preset_type.prop("checked", false);
      select_preset.show();
      var selectedPreset = null;
      for (var key in shippingPresets) {
        if (shippingPresets[key].shipping_preset_name === selectedName) {
          selectedPreset = shippingPresets[key];
        }
      }
      // Access the data for the selected preset
      var paidBy = selectedPreset.shiping_payed_by;
      var localPickupPrice = selectedPreset.local_pickup_country_price;
      var localPickupContinentPrice =
        selectedPreset.local_pickup_continent_price;
      var localPickupWorldPrice = selectedPreset.local_pickup_world_price;
      $("input[name=seller_shipping_fee_by][value=" + paidBy + "]").prop(
        "checked",
        true
      );
      $("input[name='local_pickup_country_price']").val(localPickupPrice);
      $("input[name='local_pickup_continent_price']").val(
        localPickupContinentPrice
      );
      $("input[name='local_pickup_world_price']").val(localPickupWorldPrice);
      $("input[name='shipping_preset_name']").val(selectedName);
    } else {
      shipping_preset_type.click();
      shipping_preset_type.prop("disabled", true);
      select_preset.hide();
    }
  }
  $(select_preset).on("change", function (e) {
    setSelectedPreset(allPresets);
  });
  $("#save-shiping-preset").on("click", function (e) {
    e.preventDefault();
    var action_type = $(this).attr("action-type");
    presetAction(action_type);
  });
  $("#delete-shiping-preset").on("click", function (e) {
    e.preventDefault();
    var action_type = $(this).attr("action-type");
    presetAction(action_type);
  });
  function showPresetMessage(type = true, msg = add_auction_data.wrong_msg) {
    $(".preset-message").html(msg);
    $(".preset-message").removeClass("p-message-success");
    $(".preset-message").removeClass("p-message-failed");
    if (type) {
      $(".preset-message").addClass("p-message-success");
    } else {
      $(".preset-message").addClass("p-message-failed");
    }
    $(".preset-message").show();
    setInterval(function () {
      $(".preset-message").hide();
    }, 5000);
  }
  function presetAction(action_type = "save") {
    var radioValue = $("input[name='seller_shipping_fee_by']:checked").val();
    var shipping_preset_name = $("input[name='shipping_preset_name']").val();
    var local_pickup_country_price = $(
      "input[name='local_pickup_country_price']"
    ).val();
    var local_pickup_continent_price = $(
      "input[name='local_pickup_continent_price']"
    ).val();
    var local_pickup_world_price = $(
      "input[name='local_pickup_world_price']"
    ).val();
    if (action_type == "add-new" || action_type == "update") {
      if (
        !radioValue ||
        !shipping_preset_name ||
        !local_pickup_country_price ||
        !local_pickup_continent_price ||
        !local_pickup_world_price
      ) {
        showPresetMessage(false, add_auction_data.fill_values_msg);
        return false;
      }
    }
    if (action_type == "delete" || action_type == "update") {
      shipping_preset_name = $(
        "select[name='shipping_preset_selection']"
      ).val();
    }
    var data = {
      action: "uat_seller_sihipping_preset_save",
      shiping_payed_by: radioValue,
      local_pickup_country_price: local_pickup_country_price,
      local_pickup_continent_price: local_pickup_continent_price,
      local_pickup_world_price: local_pickup_world_price,
      shipping_preset_name: shipping_preset_name,
      action_type: action_type,
    };
    // Make the AJAX request
    $.ajax({
      url: ajaxurl, // The URL for the WordPress backend endpoint
      type: "POST",
      data: data,
      success: function (response) {
        let res_status = true;
        if (response.status == "success") {
          res_status = true;
          getPresets(setPresets);
        } else {
          res_status = false;
        }
        showPresetMessage(res_status, response.message);
      },
      error: function (xhr, textStatus, errorThrown) {
        // Handle the error response
      },
    });
  }
  /* on enjter value remove error tags */
  $("input").on("input", function (event) {
    let value = $(this).val();
    let name = $(this).attr("name");
    if (name != "_regular_price") {
      if (value) {
        $(this).next("span.input-error").hide();
        let tabDivIds = $(this).closest("div[role='tabpanel']").attr("id");
        $('li[aria-controls="' + tabDivIds + '"]').removeClass("invalid-input");
      } else {
        $(this).next("span.input-error").show();
      }
    }
  });

  function Amount_value_with_currency(amount) {
    if (add_auction_data.react_currency_pos == "right") {
      var f_amount = amount + add_auction_data.wc_currency_symbol;
    } else if (add_auction_data.react_currency_pos == "right_space") {
      var f_amount = amount + " " + add_auction_data.wc_currency_symbol;
    } else if (add_auction_data.react_currency_pos == "left_space") {
      var f_amount = add_auction_data.wc_currency_symbol + " " + amount;
    } else {
      var f_amount = add_auction_data.wc_currency_symbol + amount;
    }
    return f_amount;
  }

  /* submit handler */

    $('.submit-auction-product').on('click', function (event) {
        // $('.submit-auction-product').prop('disabled', false);
        // Prevent form submission
        let actionType = $(this).data('action-type');

    if (actionType == "draft") {
      $("input[name='save-type'").val("darft");
    } else {
      $("input[name='save-type'").val("submit");
    }
    $("div#tabs-list ul li").removeClass("invalid-input");
    let validFields = [];
    // Check if required fields are empty
    const requiredFields = $('form[name="seller-auction-save"] [required]');
    let isValid = true;
    let isdraftValid = true;
    requiredFields.each(function () {
      let filedName = $(this).attr("name");
      let tabDivIds = $(this).closest("div.tab-screen").attr("id");
      $(this).next("span.input-error").hide();
      $('div#tabs-list ul li a[data-tab-id="' + tabDivIds + '"]')
        .parent()
        .removeClass("invalid-input");
      if ($(this).val().trim() === "") {
        let draftRequired = $(this).data("required-draft");
        if (actionType == "draft" && draftRequired) {
          isdraftValid = false;
        }
        $('div#tabs-list ul li a[data-tab-id="' + tabDivIds + '"]')
          .parent()
          .addClass("invalid-input");
        isValid = false;
        $(this).next("span.input-error").show();
      } else {
        validFields.push(filedName);
      }
    });

    if (actionType == "draft") {
      if (validFields.includes("product_name")) {
        isValid = true;
      }
    }

        if (isValid) {
            // $(".submit-auction-product").click();
            $("#messageBox").html(add_auction_data.submit_proccessing_msg);
            $("#messageBox").show();
            $(this).hide()
            $('form[name="seller-auction-save"]').submit(); // Submit the form if all required fields are filled
        } else {
            event.preventDefault();

      activateInvalidScreen();
    }
  });
  /* activate invalid screen */
  function activateInvalidScreen() {
    $("div#tabs-list li.invalid-input a:first-child").first().click();
  }
  /* update preview screen with latest data */
  function updatePreview() {
    var featured_image_url = "";
    var featured_image_id = "";
    var gallery_images_urls = [];
    var gallery_images_ids = [];
    var selectedImages = jQuery("#gallery_images_show img.uploaded-img");
    selectedImages.each(function (i, j) {
      if (i == 0) {
        featured_image_url = jQuery(this).attr("src");
        featured_image_id = jQuery(this).attr("data-img-id");
      } else {
        gallery_images_urls.push(jQuery(this).attr("src"));
        gallery_images_ids.push(jQuery(this).attr("data-img-id"));
      }
    });
    gallery_images_urls = gallery_images_urls.join(",");
    gallery_images_ids = gallery_images_ids.join(",");
    $("#featured_image_url").val(featured_image_url);
    $("#featured_image_id").val(featured_image_id);
    $("#gallery_images_url").val(gallery_images_urls);
    $("#gallery_images_ids").val(gallery_images_ids);


    /* new code */ 
    var interior_images_gallery_images_urls = [];
    var interior_images_gallery_images_ids = [];
    var interior_images_selectedImages = jQuery("#interior_images_show img.uploaded-img");
    interior_images_selectedImages.each(function (i, j) {
      interior_images_gallery_images_urls.push(jQuery(this).attr("src"));
      interior_images_gallery_images_ids.push(jQuery(this).attr("data-img-id"));
    });
    interior_images_gallery_images_urls = interior_images_gallery_images_urls.join(",");
    interior_images_gallery_images_ids = interior_images_gallery_images_ids.join(",");

    $("#interior_images_gallery_images_url").val(interior_images_gallery_images_urls);
    $("#interior_images_gallery_images_ids").val(interior_images_gallery_images_ids);


    var mechanical_images_gallery_images_urls = [];
    var mechanical_images_gallery_images_ids = [];
    var mechanical_images_selectedImages = jQuery("#mechanical_images_show img.uploaded-img");
    mechanical_images_selectedImages.each(function (i, j) {
      mechanical_images_gallery_images_urls.push(jQuery(this).attr("src"));
      mechanical_images_gallery_images_ids.push(jQuery(this).attr("data-img-id"));
    });
    mechanical_images_gallery_images_urls = mechanical_images_gallery_images_urls.join(",");
    mechanical_images_gallery_images_ids = mechanical_images_gallery_images_ids.join(",");

    $("#mechanical_images_gallery_images_url").val(mechanical_images_gallery_images_urls);
    $("#mechanical_images_gallery_images_ids").val(mechanical_images_gallery_images_ids);

    var other_images_gallery_images_urls = [];
    var other_images_gallery_images_ids = [];
    var other_images_selectedImages = jQuery("#other_images_show img.uploaded-img");
    other_images_selectedImages.each(function (i, j) {
      other_images_gallery_images_urls.push(jQuery(this).attr("src"));
      other_images_gallery_images_ids.push(jQuery(this).attr("data-img-id"));
    });
    other_images_gallery_images_urls = other_images_gallery_images_urls.join(",");
    other_images_gallery_images_ids = other_images_gallery_images_ids.join(",");

    $("#other_images_gallery_images_url").val(other_images_gallery_images_urls);
    $("#other_images_gallery_images_ids").val(other_images_gallery_images_ids);

    var docs_images_gallery_images_urls = [];
    var docs_images_gallery_images_ids = [];
    var docs_images_selectedImages = jQuery("#docs_images_show img.uploaded-img");
    docs_images_selectedImages.each(function (i, j) {
      docs_images_gallery_images_urls.push(jQuery(this).attr("src"));
      docs_images_gallery_images_ids.push(jQuery(this).attr("data-img-id"));
    });
    docs_images_gallery_images_urls = docs_images_gallery_images_urls.join(",");
    docs_images_gallery_images_ids = docs_images_gallery_images_ids.join(",");

    $("#docs_images_gallery_images_url").val(docs_images_gallery_images_urls);
    $("#docs_images_gallery_images_ids").val(docs_images_gallery_images_ids);

    /* preview screen setup */
    let category_preview = $(".category-preview");
    let front_img_preview = $(".front-img-preview");
    let title_preview = $(".title-preview");
    let reserver_price_preview = $(".reserver-price-preview");
    let bid_price_preview = $(".bid-price-preview");
    let local_price = $(".local_price");
    let contunent_price = $(".contunent_price");
    let worldwide_price = $(".worldwide_price");
    let shippign_payed_by = $(".shippign_payed_by");
    var uwa_auction_has_reserve = $(
      "input[name='uwa_auction_has_reserve']:checked"
    );

    /* show title in preview screen */
    title_preview.html($("input[name='product_name']").val());

    /* show category in preview screen */
    var categorySelected = $("input[name='product_category']:checked");
    var categoryText = categorySelected.next("label").text();
    category_preview.html(categoryText);

    /* show front image in preview screen */
    front_img_preview.html("");
    var img = $('<img id="dynamic-front">'); //Equivalent: $(document.createElement('img'))
    img.attr("src", $("#featured_image_url").val());
    img.attr("width", "330px");
    img.appendTo(front_img_preview);

    /* show shipping details in preview screen */
    let local_price_value = Amount_value_with_currency(
      $("input[name='local_pickup_country_price']").val()
    );
    let contunent_price_value = Amount_value_with_currency(
      $("input[name='local_pickup_continent_price']").val()
    );
    let worldwide_price_value = Amount_value_with_currency(
      $("input[name='local_pickup_world_price']").val()
    );
    local_price.text(local_price_value);
    contunent_price.text(contunent_price_value);
    worldwide_price.text(worldwide_price_value);
    var radioValue = $("input[name='seller_shipping_fee_by']:checked").val();
    shippign_payed_by.text(capitalizeFirstLetter(radioValue) + " ");

    /* show Bid starts at price in preview screen */
    let woo_ua_opening_price = Amount_value_with_currency(
      $("input[name='woo_ua_opening_price']").val()
    );
    bid_price_preview.html(woo_ua_opening_price);

    /* show reserve price in preview screen */
    let reserve_text = add_auction_data.no_reserve_text;
    if (uwa_auction_has_reserve.length > 0) {
      reserve_text = Amount_value_with_currency(
        $("input[name='woo_ua_lowest_price']").val()
      );
    }
    reserver_price_preview.html(reserve_text);
  }

  function capitalizeFirstLetter(string) {
    if (string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    }
  }

  if (jQuery(window).width() < 1024) {
    jQuery(document).on(
      "click",
      ".describe-lot-tab .ui-tabs .ui-tabs-nav li",
      function (e) {
        jQuery(".describe-lot-tab .ui-tabs .ui-tabs-nav").toggleClass(
          "all_show_items"
        );
      }
    );
  }
});

// Counter for unique IDs
var inputCount = 1;
var video_selectedMediaIds = add_auction_data.video_selectedMediaIds;

// Function to add input fields
function addInput() {
  // Show the "Add Input" button after the first input box is added
  document.getElementById('add-btn').style.display = 'block';

  // Create a new input element
  var newInput = document.createElement("input");
  newInput.type = "text";
  newInput.name = "youtube_video[]"; // Set a unique name for each input

  // Create a new label element
  var newLabel = document.createElement("label");
  newLabel.className = "label-fix-top";
  newLabel.htmlFor = "input";
  newLabel.textContent = "Video URL:";

  // Create a new div for the input and label
  var newInputBox = document.createElement("div");
  newInputBox.className = "form-box col-md-12 video-input-box";
  newInputBox.appendChild(newLabel);
  newInputBox.appendChild(newInput);

  // Create a remove button
  var removeBtn = document.createElement("span");
  removeBtn.className = "remove-btn";
  removeBtn.textContent = "X";
  removeBtn.onclick = function() {
    removeInput(this);
  };
  newInputBox.appendChild(removeBtn);

  // Append the new input box to the container
  document.getElementById("input-container").appendChild(newInputBox);

  // If a value exists for this input, pre-fill the input field
  if (video_selectedMediaIds[newInput.name] !== undefined) {
    newInput.value = video_selectedMediaIds[newInput.name];
  }

  // Increment the counter for unique IDs
  inputCount++;
}

// Function to remove input fields
function removeInput(element) {
  // Get the parent element (input box)
  var inputBox = element.parentNode;

  // Remove the input box from the container
  inputBox.parentNode.removeChild(inputBox);
}

// Pre-fill input fields with existing data
jQuery(document).ready(function() {
  // Loop through existing data and pre-fill input fields
  video_selectedMediaIds.forEach(function(item, index) {
    var videoUrl = item.youtube_video;
    var inputName = 'youtube_video[]'; // Assuming the input field name is an array

    // Create a new input element
    var newInput = document.createElement("input");
    newInput.type = "text";
    newInput.name = inputName;

    // Create a new label element
  var newLabel = document.createElement("label");
  newLabel.className = "label-fix-top";
  newLabel.htmlFor = "input";
  newLabel.textContent = "Video URL:";

  // Create a new div for the input and label
  var newInputBox = document.createElement("div");
  newInputBox.className = "form-box col-md-12 video-input-box";
  newInputBox.appendChild(newLabel);
  newInputBox.appendChild(newInput);

    // Create a remove button
    var removeBtn = document.createElement("span");
    removeBtn.className = "remove-btn";
    removeBtn.textContent = "X";
    removeBtn.onclick = function() {
      removeInput(this);
    };
    newInputBox.appendChild(removeBtn);

    // Append the new input box to the container
    document.getElementById("input-container").appendChild(newInputBox);

    // Pre-fill the input field with the video URL
    newInput.value = videoUrl;
  });
});

jQuery(document).ready(function ($) {
   // When car make is selected
  $('#cmf_make').change(function () {
      var makeId = $(this).val();
      var postId = $('#cmf_post_id').val();

      // If a make is selected, fetch models via AJAX
      if (makeId) {
          $.ajax({
              url: UAT_Ajax_Url,
              type: 'GET',
              data: {
                  action: 'get_car_models',
                  make_id: makeId,
                  cmf_post_id: postId,                 
              },
              success: function (response) {
                  $('#cmf_model').html(response).prop('disabled', false);
              }
          });
      } else {
          // If no make is selected, disable and reset the models dropdown
          $('#cmf_model').html('<option value="">Select Car Model</option>').prop('disabled', true);
      }
  });
  jQuery('#cmf_make').trigger('change');
});