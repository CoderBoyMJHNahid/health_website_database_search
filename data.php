<?php
include("db/conn.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Child and Youth </title>
    <!--	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="./assets/custom.css" rel="stylesheet">
    <!--	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>-->

    <style>
        .main_div {
            padding: 30px 122px;

        }

        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        .heading {
            font-size: 22px;
            color: #2a4a7e;
            font-weight: bold;
        }


        .para_sec1 {
            padding: 3px 2px;
            font-weight: 500;
            font-size: 16px;
        }

        p {
            line-height: 1.3;
        }

        @media screen and (min-width: 768px) {
            .main_div .right {
                padding-left: 50px;
            }
        }

        @media screen and (min-width: 1025px) {
            .main_div .right {
                padding-left: 40 px;

            }
        }
    </style>
</head>

<body>
    <div class="m-container">
        <div class="header">
            <div class="logo">
                <div class="img">
                    <a href="./index.php">
                        <img src="./assets/logo.png" width="350" alt="City of Toronto Public Health logo.">
                    </a>
                </div>
                <div class="menu-icon" id="menu-icon" style="display: none;">Menu</div>
                <div class="menu_wrapper">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="#">Visualizations </a></li>
                        <li><a href="#">Database Search</a></li>
                        <li><a href="#">About us</a></li>
                    </ul>
                </div>
            </div>
            <!-- mobile menu  -->

            <div class="menu" id="menu">
                <div class="menu-header">
                    <h2>Menu</h2>
                    <button id="close-btn" class="close-btn">&times;</button>
                </div>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#">Visualizations </a></li>
                    <li><a href="#">Database Search</a></li>
                    <li><a href="#">About us</a></li>
                </ul>
            </div>

        </div>
    </div>
    <div class="main_div">
        <div class="text_section1">

            <p class="heading">Search by Location</p>

            <p class="para_sec1">Use this section to search for multiple health indicators in a particular location,
                such as health authority region, local health area, or school district. Follow the on-screen menus to
                define the search criteria, and then click on "Preview now" to see the data table before downloading.
            </p>
            <p>Some of the indicators presented in the Health Database are provided with data available at the level of
                Local Health Areas (LHAs). Please note that some of the LHAs have been given new names in the process of
                aligning them with newly created Community Health Service Area (CHSA) geographies. To view the new
                names, click here.

                CHSA-level data is available for 195 CHSAs excluding CHSAs that are identifiable as First Nations.</p>


            <hr>
            <br>
        </div>
        <div class="search_content_wrapper">
            <div class="search_content">
                <label for=""></label>
                <select name="location_type" class="input_select" id="location_type">
                    <option value="" disabled selected>Select the City</option>
                    <option value="">Toronto</option>
                </select>
            </div>
            <div class="search_content">
                <input id="location" disabled autocomplete="false" name="location" class="input_select" />
            </div>
            <div class="search_content">
                <select id="topic" name="topic" disabled class="input_select">
                    <option value=""></option>
                    <option value="Socio Demographic Census">Socio Demographic Census</option>

                </select>
            </div>
            <div class="search_content">
                <input type="text" class="input_select" disabled autocomplete="off" name="ListSubIndicatorName"
                    id="indicator" placeholder="Select an indicator">
            </div>
            <div class="button_wrapper">
                <button class="button" disabled id="preview_btn">Preview now</button>
                <button class="button" disabled id="download_btn">Download data</button>
            </div>
        </div>


    </div>

    </div>

    <div class="table_wrapper" style="width:97%;margin:auto;display:none">
        <table id="table_lico" border="1">


        </table>
        <table id="table_lim" style="margin: 40px 0px" border="1">

        </table>


    </div>

    <div id="details-location" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h5 id="modal_title">
                </h6>
                <div>
                    <div class="content_wrapper">
                        <div id="indicatorCheckboxes"></div>
                    </div>


                    <div class="btn_wrapper_modal">
                        <button class="button_modal" id="applyChangesBtn">Check All</button>
                        <button class="button_modal" id="cancelChangesBtn">Clear All</button>
                        <button class="button_modal" type="submit" id="saveChangesBtn">Done</button>
                    </div>
                </div>
        </div>
    </div>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', () => {

            const menu_items = document.getElementsByClassName("menu-list-item")

            const menuIcon = document.getElementById('menu-icon');
            const menu = document.getElementById('menu');
            const closeBtn = document.getElementById('close-btn');

            const menuIconMega = document.getElementById('menu-icon-mega');
            const menuMega = document.querySelector('.mega_menu');

            menuIcon.addEventListener('click', () => {
                menu.classList.toggle('open');
                menuIcon.style.display = 'none';
            });
            menuIconMega.addEventListener('click', () => {
                menuMega.classList.toggle('open');
                // menuIcon.style.display = 'none';
            });

            closeBtn.addEventListener('click', () => {
                menu.classList.remove('open');
                menuIcon.style.display = 'block';
            });


            // select option 

            let neighborhood_data = [];
            let income_data = [];

            const target_location_type = document.getElementById("location_type")
            const target_location = document.getElementById("location")
            const target_topic = document.getElementById("topic")
            const btn = document.getElementById("indicator");
            const modal = document.getElementById("details-location");

            const span = document.getElementsByClassName("close")[0];

            target_location_type.addEventListener('change', () => {
                target_location.removeAttribute("disabled");
            });

            target_location.addEventListener('click', () => {
                neighborhood_data = [];
                document.getElementById("modal_title").innerHTML = "Select Neighborhood";

                document.getElementById("saveChangesBtn").setAttribute("data-region", "neighborhood");

                fetch("php/fetch_neighborhood.php").then(response => response.json()).then((res) => {
                    let html = `<div class="check_align_wrapper">`;
                    res.forEach(neighborhood => {
                        html += `<div class="check_align">
                            <label>
                            <input type="checkbox" class="modal_checkbox" name="neighborhood"
                                value="${neighborhood[0]}">${neighborhood[1]}</label>
                        
                        </div>`
                    });
                    document.getElementById("indicatorCheckboxes").innerHTML = html;
                    html += `</div>`;
                    modal.style.display = 'block';

                }).catch((err) => console.log(err))
                target_topic.removeAttribute("disabled");
            });
            target_topic.addEventListener('change', () => {
                btn.removeAttribute("disabled");
            });


            btn.addEventListener("click", () => {
                income_data = [];
                document.getElementById("saveChangesBtn").setAttribute("data-region", "indicator");
                document.getElementById("indicatorCheckboxes").innerHTML = `
                <div class="check_align_wrapper">
                   <div class="check_align">
                    <label>
                        <input type="checkbox" class="modal_checkbox" name="income"
                        value="licoat">LICO AT</label>
                            
                    </div>
                    <div class="check_align">
                    <label>
                        <input type="checkbox" class="modal_checkbox" name="income"
                        value="limat">LIM AT</label>
                    </div>
                </div>`
                modal.style.display = "block";

            })

            span.onclick = function () {
                modal.style.display = "none";
            }

            window.onclick = function (event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            }

            const clear_btn = document.querySelector("#cancelChangesBtn");
            const apply_btn = document.querySelector("#applyChangesBtn");
            const checkbox = document.getElementsByClassName("modal_checkbox");

            clear_btn.addEventListener('click', (e) => {
                e.preventDefault();
                for (let i = 0; i < checkbox.length; i++) {
                    checkbox[i].checked = false;
                }
            });
            apply_btn.addEventListener('click', (e) => {
                e.preventDefault();
                for (let i = 0; i < checkbox.length; i++) {
                    checkbox[i].checked = true;
                }
            })

            document.getElementById("saveChangesBtn").addEventListener('click', (e) => {
                modal.style.display = "none";
                const region = document.getElementById("saveChangesBtn").getAttribute("data-region");
                if (region === "neighborhood") {
                    for (let i = 0; i < checkbox.length; i++) {
                        if (checkbox[i].checked) {
                            neighborhood_data.push(checkbox[i].value);
                        }
                    }
                } else if (region === "indicator") {
                    for (let i = 0; i < checkbox.length; i++) {
                        if (checkbox[i].checked) {
                            income_data.push(checkbox[i].value);
                        }
                    }


                    $main_data = JSON.stringify({
                        neigh: neighborhood_data,
                        income: income_data
                    })

                    fetch("php/fetch_table_data.php",
                        {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: $main_data
                        }
                    ).then(response => response.json()).then((res) => {
                        console.log(res);

                        if (res.data.hasOwnProperty("licoat")) {
                            let html = `
                                <thead>
                                    <tr>
                                        <th rowspan="2">Neighbourhood Name</th>
                                        <th colspan="15">POPULATION IN LOW-INCOME BASED ON LOW-INCOME CUT-OFFS - AFTER-TAX (LICO-AT)
                                        </th>
                                    </tr>
                                <tr style="font-size:15px">
                                    <th>Total - Population to whom Low Income Concepts Are Applicable (Denominator)</th>
                                    <th>In LICO-AT</th>
                                    <th>In LICO-AT (%)</th>
                                    <th>Total - Population to whom Low Income Concepts Are Applicable (0-17 yrs)</th>
                                    <th>In LICO-AT (0-17 yrs)</th>
                                    <th>In LICO-AT (0-17 yrs) (%)</th>
                                    <th>Total - Population to whom Low Income Concepts Are Applicable (0-5 yrs)</th>
                                    <th>In LICO-AT (0-5 yrs)</th>
                                    <th>In LICO-AT (0-5 yrs) (%)</th>
                                    <th>Total - Population to whom Low Income Concepts Are Applicable (18-64 yrs)</th>
                                    <th>In LICO-AT (18-64 yrs)</th>
                                    <th>In LICO-AT (18-64 yrs) (%)</th>
                                    <th>Total - Population to whom Low Income Concepts Are Applicable (65+ yrs)</th>
                                    <th>In LICO-AT (65+ yrs)</th>
                                    <th>In LICO-AT (65+ yrs) (%)</th>
                                </tr>
                                </thead>
                                <tbody>`;

                            for (let i = 0; i < res.data.licoat.length; i++) {
                                html += `
                                <tr>
                                    <td>${res.data.licoat[i].name}</td>
                                    <td>${res.data.licoat[i].totalPopulation}</td>
                                    <td>${res.data.licoat[i].inLicoAt}</td>
                                    <td>${res.data.licoat[i].inLicoAtPercentage}</td>
                                    <td>${res.data.licoat[i].population0To17}</td>
                                    <td>${res.data.licoat[i].inLicoAt0To17}</td>
                                    <td>${res.data.licoat[i].inLicoAt0To17Percentage}</td>
                                    <td>${res.data.licoat[i].population0To5}</td>
                                    <td>${res.data.licoat[i].inLicoAt0To5}</td>
                                    <td>${res.data.licoat[i].inLicoAt0To5Percentage}</td>
                                    <td>${res.data.licoat[i].population18To64}</td>
                                    <td>${res.data.licoat[i].inLicoAt18To64}</td>
                                    <td>${res.data.licoat[i].inLicoAt18To64Percentage}</td>
                                    <td>${res.data.licoat[i].population65Plus}</td>
                                    <td>${res.data.licoat[i].inLicoAt65Plus}</td>
                                    <td>${res.data.licoat[i].inLicoAt65PlusPercentage}</td>
                                </tr>
                            `;

                            }
                            document.querySelector("#table_lico").innerHTML = html;
                        }

                        if (res.data.hasOwnProperty("limat")) {
                            let htmlLim = `
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Neighbourhood Name</th>
                                            <th colspan="15">POPULATION IN LOW-INCOME BASED ON LOW-INCOME MEASURE - AFTER-TAX (LIM-AT)
                                            </th>
                                        </tr>
                                        <tr style="font-size:15px">
                                            <th>Total - Population to whom Low Income Concepts Are Applicable (Denominator)</th>
                                            <th>In LIM-AT</th>
                                            <th>In LIM-AT (%)</th>
                                            <th>Total - Population to whom Low Income Concepts Are Applicable (0-17 yrs)</th>
                                            <th>In LIM-AT (0-17 yrs)</th>
                                            <th>In LIM-AT (0-17 yrs) (%)</th>
                                            <th>Total - Population to whom Low Income Concepts Are Applicable (0-5 yrs)</th>
                                            <th>In LIM-AT (0-5 yrs)</th>
                                            <th>In LIM-AT (0-5 yrs) (%)</th>
                                            <th>Total - Population to whom Low Income Concepts Are Applicable (18-64 yrs)</th>
                                            <th>In LIM-AT (18-64 yrs)</th>
                                            <th>In LIM-AT (18-64 yrs) (%)</th>
                                            <th>Total - Population to whom Low Income Concepts Are Applicable (65+ yrs)</th>
                                            <th>In LIM-AT (65+ yrs)</th>
                                            <th>In LIM-AT (65+ yrs) (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;


                            for (let i = 0; i < res.data.limat.length; i++) {
                                htmlLim += `
                                <tr>
                                    <td>${res.data.limat[i].name}</td>
                                    <td>${res.data.limat[i].totalPopulation}</td>
                                    <td>${res.data.limat[i].inLimAt}</td>
                                    <td>${res.data.limat[i].inLimAtPercentage}</td>
                                    <td>${res.data.limat[i].population0To17}</td>
                                    <td>${res.data.limat[i].inLimAt0To17}</td>
                                    <td>${res.data.limat[i].inLimAt0To17Percentage}</td>
                                    <td>${res.data.limat[i].population0To5}</td>
                                    <td>${res.data.limat[i].inLimAt0To5}</td>
                                    <td>${res.data.limat[i].inLimAt0To5Percentage}</td>
                                    <td>${res.data.limat[i].population18To64}</td>
                                    <td>${res.data.limat[i].inLimAt18To64}</td>
                                    <td>${res.data.limat[i].inLimAt18To64Percentage}</td>
                                    <td>${res.data.limat[i].population65Plus}</td>
                                    <td>${res.data.limat[i].inLimAt65Plus}</td>
                                    <td>${res.data.limat[i].inLimAt65PlusPercentage}</td>
                                </tr>
                            `;

                            }

                            htmlLim += "</tbody>"
                            document.querySelector("#table_lim").innerHTML = htmlLim;

                        }


                    }).catch(error => console.log(error));


                    document.querySelector("#preview_btn").removeAttribute("disabled");
                    document.querySelector("#download_btn").removeAttribute("disabled");
                }
                // console.log(neighborhood_data, "neighborhood");
                // console.log(income_data, "income_data");

            })

            document.querySelector("#preview_btn").onclick = () => {
                document.querySelector(".table_wrapper").style.display = "block";
            }
            document.querySelector("#download_btn").onclick = () => {
                const html_table = document.querySelector(".table_wrapper").innerHTML;

                fetch("php/excel_file_download.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: new URLSearchParams({ html_table: html_table })
                })
                    .then((response) => response.blob())
                    .then((blob) => {
                        const link = document.createElement("a");
                        link.href = URL.createObjectURL(blob);
                        link.download = "table_data.xls";
                        link.click();
                    })
                    .catch((error) => console.error("Error:", error));

            }

        });
    </script>
</body>

</html>