<?php
   /* Template Name: Submission page */
   get_header(); ?>
<link rel="stylesheet" href="<?php echo UAT_THEME_PRO_CSS_URI; ?>/vendor.css" type="text/css" media="screen" />
<section class="vendor-main" style="width:1550px;max-width:100%;margin:0 auto;">
    <div class="container">
     
        <div class="Sales-Tab">
            <div class="Sales-tab-list">
                <div class="tab-nav-row">
                    <ul id="tabs-nav">
                        <li><a href="tab1">Sales Overview</a></li>
                        <li><a href="tab2">in auction</a></li>
                        <li><a href="tab3">Submission</a></li>
                        <li><a href="tab4">Sold</a></li>
                        <li><a href="tab5">Payments</a></li>
                    </ul>
                    <div class="right-bulk-link">
                        <a class="bulk-link" href="#">Bulk Upload</a>
                        <a class="btn-submit" href="#">Submit New Object</a>
                    </div>
                </div>
                <div class="Sales-tab-con">
                    <div id="tabs-content">
                        <div id="tab1" class="salse_tab-content">
                            <div class="page-heading">
                                <h1>Submissions</h1>
                                <ul class="review-and-user">
                                    <li class="user_data"><a href="#">user btde751</a></li>
                                    <li class="reviews_details"><span>100%</span><a href="#">29 reviews</a></li>
                                </ul>
                            </div>
                            <div class="tab_con_box">
                                <div class="tab_con_box-left">
                                    <h3>Status</h3>
                                    <div class="vendor-switch-label">
                                        <label class="checkbox_switch" for="checkbox-1">
                                        <input type="checkbox" id="checkbox-1" />
                                        <div class="checkbox-slider round"></div>
                                        </label>
                                        <p class="mr-bottom-0">Draft (0)</p>
                                    </div>

                                    <div class="vendor-switch-label">
                                        <label class="checkbox_switch" for="Adjustment">
                                        <input type="checkbox" id="Adjustment" />
                                        <div class="checkbox-slider round"></div>
                                        </label>
                                        <p class="mr-bottom-0">Adjustment Required (2) </p>
                                    </div>

                                     
                                        
                                     
                                </div>
                                <div class="tab_con_box-right">
                                    <div class="search_and_filter">
                                        <div class="search_bl">
                                            <input class="form-control" placeholder="Search here" name="srch-term" id="srch-term" type="text">
                                            <button class="search-btn" type="button"></button>
                                        </div>
                                        <div class="filter_bl">
                                            <div class="custom-icon_select">
                                            <select name="sources" id="sources" class="custom-select sources" placeholder="Source Type">
                                                <option value="profile">Sort By</option>
                                                <option value="word">Word</option>
                                                <option value="hashtag">Hashtag</option>
                                            </select>
                                            <span onclick="open_select(this)" class="icon_select_mate"><svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.41 7.84L12 12.42l4.59-4.58L18 9.25l-6 6-6-6z"></path>
                                                <path d="M0-.75h24v24H0z" fill="none"></path>
                                                </svg>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Breadcrumb-data">
                                        <ul class="custom-Breadcrumb">
                                            <li><a href="#">Home</a></li>
                                            <li><a href="#">First link</a></li>
                                            <li><a href="#">Second link</a></li>
                                            <li><a href="#">Another lengthier link</a></li>
                                            <li><a href="#">Final link in the hierarchy</a></li>
                                            <li><a href="#">Current page</a></li>
                                        </ul>
                                    </div>
                                    <div class="product_data">
                                        <table>
                                            <tr>
                                                <th class="check-box"></th>
                                                <th class="image-box"></th>
                                                <th class="Title-box">Title</th>
                                                <th class="Auction-box">Auction</th>
                                                <th class="Status-box">Status</th>
                                                <th class="highest-bid-box">Highest bid</th>
                                                <th class="action-box"></th>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="check-box"><input type="checkbox"></td>
                                                <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/4739795.jpg" width="100px" height="" alt="" /></td>
                                                <td class="Title-box"><h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur corrupti quia exercitationem autem nihil unde doloribus fuga</h3></td>
                                                <td class="Auction-box">Lorem ipsum dolor sit amet consectetur</td>
                                                <td class="Status-box">
                                                    <h4>Lorem, ipsum dolor.</h4>
                                                    <small>Lorem ipsum dolor sit amet.</small>
                                                    <a href="#">Feedback From Expert</a>
                                                </td>
                                                <td class="highest-bid-box">
                                                    <small>RESERVE PRICE</small>
                                                    <h2>$ 222</h2>
                                                </td>
                                                <td class="action-box">
                                                    <select>
                                                        <option>Action</option>
                                                        <option>Action 2</option>
                                                        <option>Action 3</option>
                                                        <option>Action 4</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab2" class="salse_tab-content">
                            <div class="page-heading">
                                        <h1>Submissions</h1>
                                    </div>
                                    <P>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus, tempore alias? Sequi expedita eaque placeat eius illo autem tenetur quod a reiciendis at maxime quam atque illum ad minus voluptas reprehenderit blanditiis esse ullam, quis suscipit molestiae hic omnis alias. Distinctio nobis non, modi velit quam quo quas a expedita natus numquam repudiandae corrupti. Ipsa qui laboriosam, obcaecati delectus corrupti ducimus, perspiciatis rem tenetur numquam eius est odit exercitationem magni? Tempora animi quos magni neque? Ea corporis quis magnam, aspernatur, vitae eius nulla, sapiente eum unde deleniti enim officiis. Rem perferendis earum consequatur ut molestias illo molestiae assumenda fuga excepturi ratione adipisci, quaerat quibusdam distinctio. Accusamus fugit molestiae praesentium dicta! Incidunt similique cum eaque, impedit quos nihil voluptatum libero odio id veniam ipsum error perspiciatis quia saepe fuga beatae nesciunt doloribus quod amet corrupti consequuntur sunt minus rerum omnis. Illum doloremque perferendis pariatur aliquid sit obcaecati fugiat blanditiis deleniti. Ratione voluptas ea, vero ipsa pariatur amet aut et laudantium! Asperiores possimus vitae neque iusto earum at voluptatem consectetur, laborum, saepe excepturi qui temporibus, iste quos maxime id. Excepturi esse quae nihil quibusdam recusandae? Sed sapiente quas doloremque culpa distinctio, soluta nostrum fugiat quo ducimus. Dignissimos doloremque quidem tenetur temporibus officia?</P>
                                </div>
                        <div id="tab3" class="salse_tab-content">
                                <div class="page-heading">
                                    <h1>Submissions</h1>
                                </div>
                                <P>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae vitae enim consequatur deleniti, sit qui molestias architecto, ut sunt, fugit totam? Iste modi provident error cum maxime, aliquam, odit fugit nulla reprehenderit voluptatibus porro ratione aut perferendis. Earum sint officia quis soluta architecto exercitationem, ad totam, praesentium iusto voluptatibus rem id consequatur ea quibusdam! Eum, ullam provident ducimus ab minima facere distinctio esse at, quasi recusandae voluptatibus. Rem repudiandae aspernatur quas esse, laudantium, eveniet, laboriosam asperiores impedit voluptas explicabo dolorem voluptatibus excepturi? Obcaecati, maiores explicabo iusto consequatur magnam unde excepturi nulla deserunt, debitis, cumque labore eaque quod eveniet animi maxime non porro inventore dolorem nostrum impedit quas dicta aliquid. Quod accusantium iusto delectus assumenda quam autem quia quis, sapiente a libero eligendi asperiores at provident officia laudantium tenetur. Tempora harum nesciunt totam aut, ea nostrum facere itaque at neque perferendis, aliquam nam impedit vitae. Dolores quibusdam laboriosam perspiciatis quo. Aliquam quaerat aliquid labore fuga maiores asperiores cum, accusantium impedit fugit ipsam optio sit reprehenderit dicta dolores voluptatum numquam magni incidunt, ipsa omnis eum. Porro repellendus vitae rem excepturi illum, eaque voluptas autem. Dolorem molestias eaque vero. Voluptatibus ullam maxime tenetur asperiores tempore sequi. Quos fuga vitae at exercitationem, incidunt temporibus laudantium modi veniam, provident dolor minima ipsum nihil reprehenderit possimus laborum reiciendis soluta suscipit assumenda neque ut deleniti quis. Similique vitae fuga nostrum, id praesentium delectus suscipit tenetur qui deleniti voluptatem ut dolorem neque nisi officiis mollitia tempore doloremque minima, facilis facere perferendis nulla nemo. Magnam laboriosam iure recusandae similique.</P></div>
                        <div id="tab4" class="salse_tab-content">
                            <div class="page-heading">
                                <h1>Submissions</h1>
                            </div>
                            <P>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perspiciatis officia exercitationem dignissimos nobis quis placeat tempora, alias quia esse nostrum debitis quas repellendus voluptatem nesciunt corporis aut quae earum sed aliquam vero molestias nemo porro! Debitis adipisci numquam quod id accusantium necessitatibus error, architecto odit inventore dolorem, illo nulla distinctio. At, iusto. Modi sunt maiores repudiandae iste rerum ea. Culpa obcaecati, tempore, omnis beatae illum nihil minima odit minus modi optio suscipit blanditiis eligendi quisquam laborum. Sunt ipsa, dolorem sequi dolore, officia nisi corrupti placeat, minima exercitationem quos magnam fugit. Debitis recusandae aliquam ex voluptates qui iusto inventore itaque dolorem alias adipisci asperiores quae magni officia expedita rerum cupiditate temporibus, nisi dolores architecto harum nesciunt delectus laborum. Iusto explicabo quos voluptatum voluptatem at natus magnam illo porro quisquam, ratione, quo harum? Repellendus porro facere, consequuntur aperiam vel hic minus, perspiciatis accusantium laudantium, optio corporis pariatur nisi corrupti iusto aliquid laborum totam provident! Minima, id officiis aut quos maiores tenetur exercitationem, deserunt odit libero enim perspiciatis placeat? Aut molestias minus nulla, aliquid officiis nostrum sunt ut voluptatum, sapiente modi explicabo ducimus eos accusantium commodi obcaecati praesentium animi. Porro facilis aperiam iure aliquam amet cupiditate, reiciendis temporibus incidunt quo! Doloremque, sint libero magni deserunt est nulla vel eius asperiores similique, voluptatem iusto excepturi delectus incidunt dolorem temporibus accusamus fugit fugiat provident dolor nemo exercitationem ipsum corporis ab. Perferendis quis quo sunt, officiis perspiciatis iste consectetur iusto, tempora aspernatur quasi voluptatibus minus iure placeat quisquam sint ipsam! Consectetur omnis vel architecto veritatis cumque, hic ducimus fugit odio. A, error. Quisquam, aut animi sequi exercitationem voluptatum praesentium, veritatis fugiat voluptas delectus atque reprehenderit culpa quia numquam, magni doloribus illum recusandae magnam mollitia perferendis! Ducimus similique quibusdam provident minima dicta, esse rerum, cum animi quidem laudantium repellat fuga commodi nobis error impedit, voluptate rem inventore minus veniam incidunt? Quaerat dolorum similique rerum, quos recusandae iusto quae quia porro quasi assumenda minus corrupti in nihil atque molestias deleniti officia accusamus sunt beatae. Architecto ab excepturi sequi pariatur! Accusamus recusandae animi voluptas. Harum asperiores modi ipsum. Ut voluptatum facilis incidunt qui, dicta eligendi harum, odit quo, nulla esse est quod. Fugit porro, officiis eum fuga hic ratione sapiente velit nemo minus eius doloremque, ipsum maiores quos nostrum optio quam earum corrupti! Harum autem iure optio culpa odio reprehenderit ipsa dolor neque provident blanditiis. Similique nihil, accusamus reiciendis voluptas aspernatur quam velit blanditiis ipsa repudiandae facilis accusantium culpa cum modi laborum ullam neque, magnam alias ea molestias amet at. In, sint exercitationem tempore, temporibus sapiente rem, inventore nesciunt molestias aperiam neque quo ipsum officiis provident. Facilis explicabo earum cumque, aspernatur veritatis recusandae inventore molestias magnam sed consequatur possimus vero exercitationem sapiente odit nam. Voluptatum aliquid itaque commodi accusantium alias libero hic. Rerum similique placeat dolores nisi, mollitia consequatur! Repudiandae id harum quam illum assumenda quasi et aliquam! Sint tenetur quam sed veritatis dolor atque aperiam fugiat consequatur minus. Eius, quaerat quidem. Porro numquam officiis repellendus ipsa, corrupti rerum quisquam incidunt quae! Totam nihil accusamus fuga aut reprehenderit ullam!</P></div>
                        <div id="tab5" class="salse_tab-content">
                            <div class="page-heading">
                                <h1>Submissions</h1>
                            </div>
                            <P>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nihil, maxime dolore? Voluptas qui, id et, soluta impedit illum necessitatibus praesentium excepturi error velit doloremque dignissimos atque, ea nobis quaerat. Sequi dolorum laboriosam tenetur officiis inventore minus recusandae sint maiores eius ad. Dicta, ducimus recusandae in consectetur culpa molestiae. Maiores rem neque laborum libero, voluptates sed quidem, sapiente assumenda esse et praesentium? Hic ea dolorum nulla quisquam. Sed porro, voluptatum non odio obcaecati adipisci necessitatibus ex dolor itaque, accusamus sunt modi fugit quae delectus quo aut atque aliquam perferendis enim architecto ea tenetur temporibus qui facilis. Corporis exercitationem expedita delectus fugiat iste nesciunt deleniti. Amet enim neque minus id aliquam quo laborum vitae ea, recusandae alias officiis! Voluptatibus doloribus, inventore laudantium, iusto assumenda facere eius, ipsam sequi voluptate id exercitationem. Fugiat dolores ex cum quos at impedit nihil ipsum aperiam sed? Dolor amet suscipit obcaecati dolorum sequi maiores numquam non eveniet nobis rerum itaque asperiores eius molestias, ad ducimus sit cum voluptatum labore nemo voluptas hic necessitatibus accusantium! Alias laudantium nemo maiores sed doloribus quis aspernatur suscipit veniam dolore illo vero modi dolorem sint ducimus eius cupiditate tempore optio, velit ab quos corporis soluta assumenda a. Itaque ullam, dolore repellendus numquam, laudantium est suscipit, amet rem ex repudiandae reprehenderit earum placeat quas! Ex repellat at debitis, voluptatem tenetur enim, provident eos fugit animi, consequuntur recusandae ea facere? Voluptate eveniet ad consectetur inventore numquam odio sapiente reprehenderit ipsa maxime tempore quidem id dolorum vel error culpa voluptatem ipsam, aliquam officia accusamus aut expedita cupiditate rem, velit commodi! Quasi aut, saepe est, deserunt ipsam fugit nesciunt illo assumenda nisi velit eos aliquam sed aperiam eaque. Provident, exercitationem earum! Earum ut ab in quisquam aperiam non voluptate tempore est molestiae quia optio, architecto ad eius, atque consequuntur voluptas sed veniam deleniti delectus itaque ratione. Suscipit rerum quia quae repellat ab. Sed eius tempora ad? Assumenda, debitis? Error recusandae quod rem blanditiis! Id itaque facere iure suscipit blanditiis nostrum nulla earum. Alias, numquam tempore. Omnis error ad, facere ullam repellendus dicta rem praesentium nesciunt minus esse nobis, assumenda ab harum! Soluta, beatae? Debitis dicta iure maiores alias fuga pariatur asperiores eum dolore incidunt voluptate vel beatae harum similique, iusto labore commodi temporibus quibusdam adipisci quod et? Assumenda quam nam quidem vitae provident ut, veritatis repellendus deleniti ducimus inventore illum unde explicabo minus reiciendis labore doloremque consequuntur repellat quis dignissimos delectus nisi amet sed! Magni et voluptatum deleniti illum exercitationem mollitia est, nisi vel ipsam explicabo recusandae quidem, nulla voluptatibus debitis illo? Est expedita sint voluptatibus minima cupiditate. Rerum, minima cum? Possimus minima sunt nisi voluptatem nobis aspernatur illum iusto repellendus officiis in eveniet numquam nulla tempore porro ea deserunt, eos necessitatibus blanditiis quaerat labore. Vero aliquid ad ipsa quidem sunt ipsum a consequatur assumenda molestiae odit minima, fuga, facere harum quasi doloremque quo incidunt dignissimos recusandae maiores? Expedita iure itaque a. Voluptas eaque natus cupiditate vel ea placeat dolores velit nesciunt quibusdam numquam nemo quasi maxime reprehenderit dolore rerum facilis architecto ipsa animi, repellendus magni. Doloribus voluptate cum atque vitae ad nostrum quaerat numquam quidem adipisci ipsum maiores quae, dolores voluptas. Quibusdam dolorem deleniti quasi sunt velit eveniet, debitis, pariatur assumenda blanditiis modi nam maiores repellendus reprehenderit omnis error ullam, nemo tempore officiis aut qui iusto? Obcaecati sint illum architecto animi ipsa earum nam quas, harum rerum ratione, ex eveniet explicabo inventore, maiores voluptatem molestiae magnam aspernatur modi quod expedita in nemo repellendus? Ex reiciendis dolor sequi esse natus beatae illo, asperiores aperiam quod atque accusamus necessitatibus ab nam. Dicta quisquam nulla eum asperiores accusamus eligendi et itaque? Eius cum sit atque, eveniet ea dicta soluta optio repudiandae autem. Fugiat ipsam corrupti animi, perferendis, ipsum similique, excepturi iste delectus quod itaque reprehenderit unde modi? Numquam fugit, quasi voluptates a sint in? Nihil quaerat ratione explicabo dolore corporis magnam itaque incidunt quibusdam ipsam facilis, tempore asperiores eaque consectetur blanditiis veniam fuga non eligendi quod. Sunt laboriosam quia nihil optio dolores culpa doloremque assumenda? Eum, maiores doloribus eaque nulla error quae ratione debitis tempora repudiandae sint iure vel tenetur quas doloremque? Id quis repudiandae voluptate rerum in aliquam placeat dolore sapiente facere! Fugit culpa est, explicabo doloremque asperiores veniam, reiciendis quas adipisci fuga nulla dolorem pariatur, ipsam sunt aspernatur excepturi earum commodi reprehenderit corrupti eaque ratione quaerat rerum. Perferendis laudantium repellendus sequi atque? Sit, itaque placeat, cumque reiciendis accusamus culpa iste voluptatum eum est eaque a quod similique deserunt doloremque animi blanditiis mollitia cum? Voluptates, quibusdam quia sapiente neque obcaecati ut sunt voluptate ex voluptatibus fuga maxime, totam repellendus reprehenderit aspernatur nostrum rerum, pariatur consequuntur quam asperiores dolor quo sint. Ex, quas eos. A, impedit delectus temporibus, voluptate culpa modi cumque at illo, adipisci sed iusto officiis unde! Quis facilis culpa id harum voluptate, dicta nisi corrupti repudiandae illo atque. Esse accusamus fuga doloremque quod qui nobis harum assumenda voluptate nisi provident modi voluptatum, omnis corporis veritatis neque? Sit, porro ab dolores autem id voluptas necessitatibus ea similique beatae veritatis pariatur ex a eveniet. Rerum optio animi nesciunt exercitationem quibusdam provident officia. Praesentium at rem illum sed non illo veritatis soluta et harum quas sunt corrupti repellat sit asperiores placeat, sint voluptatem sapiente vero. Molestias similique porro nemo dolore aliquid. Placeat, architecto debitis. Perspiciatis deserunt reiciendis delectus vel magnam aperiam nulla quo in, nemo tempore reprehenderit at libero veritatis quia distinctio fuga placeat eius, cupiditate doloremque molestias eos? Fuga sequi officia facilis harum laborum magni, ab voluptatibus? Amet tempore molestiae eaque sit corporis, tempora possimus eligendi consequuntur totam est hic minima rem aliquam commodi ullam nostrum illo eum soluta officia quo porro error nulla iusto labore? Quaerat nostrum accusamus vitae iure voluptatibus quod repudiandae dolore, totam est, possimus atque quibusdam magni qui pariatur voluptatum ratione labore, harum rerum. Magni accusamus harum, maxime eum perferendis reiciendis molestiae hic incidunt consectetur inventore mollitia ex quo nobis aliquid placeat autem quod voluptatibus velit ad odit totam consequuntur. Earum sapiente assumenda fuga possimus. Aspernatur unde quibusdam, minus voluptates, modi corrupti cupiditate provident quis beatae tempora possimus amet illum aliquam. Suscipit, pariatur.</P>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        
     
   <div class="container">
   
   </div>
   </div>
</section>
 <script>
    // Show the first tab and hide the rest
    jQuery('#tabs-nav li:first-child').addClass('active');
    jQuery('.salse_tab-content').hide();
    jQuery('.salse_tab-content:first').show();

    // Click function
    jQuery('#tabs-nav li').click(function(){
    jQuery('#tabs-nav li').removeClass('active');
    jQuery(this).addClass('active');
    jQuery('.salse_tab-content').hide();
    
    var activeTab = jQuery(this).find('a').attr('href');
    jQuery(activeTab).fadeIn();
    return false;
    });



  
 </script>
<?php get_footer();