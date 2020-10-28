
          window.onload = function() {


            function getRandomColor(i) {
              var color = [
                '#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6',
          		  '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
          		  '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
          		  '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
          		  '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC',
          		  '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
          		  '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
          		  '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
          		  '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
          		  '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF']
              return color[i]
            }

            document.querySelector('#radioList').addEventListener('click', ev => {

              const radioBase = document.querySelector('#inlineRadio1');
              document.querySelector('#loaderfa').style.display = "none";
              document.querySelector('#settingBase').style.display = "none";
              document.querySelector('#setting').innerHTML = "";
              document.querySelector('#sendButtonn').disabled = true
              if (radioBase.checked == true){
                document.querySelector('#fileShow').style.display = "none";
                document.querySelector('#baseShow').style.display = "block";
              } else {
                document.querySelector('#fileShow').style.display = "block";
                document.querySelector('#baseShow').style.display = "none";
              }

            });


            var myDataSava = []
            var totalSet = []
            var endUcanSwoh = false

            var cutConfig = {
              seg: [],
              data: null,
              dataString: "",
              maxData: {},
              totalData: {}
            }

            document.getElementById('nbseg').addEventListener('change', function() {
              var qty = document.getElementById('nbseg').value
              document.querySelector('#selSeg').innerHTML = ''
              var refresh = []
              for (var i = 0; i < qty; i++) {
                refresh[i] = cutConfig.seg[i]
                var opt = document.createElement('option');
                opt.appendChild(document.createTextNode("Segement "+ (Number(i)+1)));
                document.querySelector('#selSeg').appendChild(opt);
                opt.value = Number(i)+1;
              }
              cutConfig.seg = refresh
              updateGraph()
            });

            document.querySelector('#selSeg').addEventListener('change', ev => {
              var setting = document.querySelector('#setting')
              for (var i = 0; i < setting.children.length; i++) {
                if (typeof cutConfig.seg[ev.target.value] != "object"){
                  cutConfig.seg[ev.target.value-1] = {}
                }
                var o = cutConfig.seg[ev.target.value-1][setting.children[i].children[0].textContent] || 0
                setting.children[i].children[1].value = o
              }
            });

            Array.prototype.diff = function(a) {
                return this.filter(function(i) {return a.indexOf(i) < 0;});
            };

            document.getElementById('file').addEventListener('change', function() {
              myDataSava = []
              endUcanSwoh = false
              document.querySelector('#loaderfa').style.display = "block";
              document.querySelector('#settingBase').style.display = "none";
              document.querySelector('#setting').innerHTML = "";
              var file = document.getElementById('file').files[0]
              console.log(file);
              var reader = new FileReader();
              var formData = new FormData(document.querySelector('#myForm'));
              console.log(formData);
              formData.set('path', 'decoupe');
              reader.readAsText(file, "UTF-8");
              boucleAgain()
              reader.onload = function (evt){
                  const emails = evt.target.result.match(/[a-zA-Z0-9_\-\+\.]+@[a-zA-Z0-9\-]+\.([a-zA-Z]{2,4})(?:\.[a-zA-Z]{2})?/g);

                  if(emails){
                      storeFile(formData, () => {
                          sendToServer(emails.length, [emails, [...formData][1][1]], '/liste/create', () => {})
                      });
                      myDataSava = emails
                      fetch('{{route("liste.get")}}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        body: JSON.stringify({id: document.getElementById('exampleFormControlSelect1').value, data: "emails"}),
                      })
                      .then( (res) =>  {
                        if (res.status != 500){
                          res.text()
                          .then( (json) =>  {
                            loadGraph(json)
                          })
                        }else{
                          alertify.error('Le serveur à rencontrer un probleme lors du traitement des données.');
                        }
                      });
                  }else{
                      alert('Votre fichier ne contient pas de mails');
                  }

              }
            })


            document.getElementById('exampleFormControlSelect1').addEventListener('change', function() {
              document.querySelector('#loaderfa').style.display = "block";
              document.querySelector('#settingBase').style.display = "none";
              document.querySelector('#setting').innerHTML = "";
              console.log("send")
              fetch('{{route("liste.get")}}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                body: JSON.stringify({id: document.getElementById('exampleFormControlSelect1').value}),
              })
              .then( (res) =>  {
                if (res.status != 500){
                  res.text()
                  .then( (json) =>  {
                    loadGraph(json)
                  })
                }else{
                  alertify.error('Le serveur à rencontrer un probleme lors du traitement des données.');
                }
              });
            });

            function boucleAgain(){
              console.log('pasdsdsse');
              setTimeout(function(){
                console.log('passe');
                if (endUcanSwoh){
                  var dataToSend = JSON.stringify({total: myDataSava, use: totalSet});
                  fetch('{{route("liste.getDiff")}}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    body: dataToSend,
                  })
                    .then( (res) =>  {
                      res.text()
                      .then( (json) =>  {
                        cutConfig.data[cutConfig.data.length-1][2] = Object.values(json)
                      })
                    })
                } else {
                  boucleAgain()
                }
              }, 1000);
            }

            function loadGraph(json){
              var data = JSON.parse(json)
              var update = [];
              data = Object.values(data)
              console.log(data);
              fai = {}
              // data[1] = Object.values(data[1])
              if (data[0] == "ok"){
                data[0] = myDataSava
              }
              myDataSava = data[0]
              cutConfig.dataString = data[0].join('\n');
              json = data[1]
              var email = {}
              var result = []
              totalSet = []
              var count = 0
              for (var i = 0; i < Object.values(json).length; i++) {
                email[Object.keys(json)[i]] = []
                for (var y = 0; y < json[Object.keys(json)[i]].length; y++) {
                  var reg = new RegExp("^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@"+ json[Object.keys(json)[i]][y] +"$","igm");
                  var match = cutConfig.dataString.match(reg)
                  if (match != null){
                    email[Object.keys(json)[i]] = email[Object.keys(json)[i]].concat(match)
                  }
                  totalSet = totalSet.concat(match)
                }
                count = (Number(count) + Number(email[Object.keys(json)[i]].length))
                result[i] = [Object.keys(json)[i], email[Object.keys(json)[i]].length, email[Object.keys(json)[i]]]
              }
              result.push(["FAI inconnu", data[0].length - count, []])
              console.log(result);
              data[1] = result
              for (var i = 0; i < data[1].length; i++) {
                  cutConfig.data = data[1]
                  cutConfig.maxData[data[1][i][0]] = data[1][i][1]
                  cutConfig.totalData[data[1][i][0]] = 0
                  update[i] = {
                    label: data[1][i][0],
                    backgroundColor: getRandomColor(i),
                    data: [0,data[1][i][1]]
                  }
                if (data[1][i][1] > 0){
                  var div = document.createElement("div");
                  var label = document.createElement("label");
                  var input = document.createElement("input");
                  div.classList.add("form-group");
                  div.classList.add("col-md-2");
                  label.setAttribute("for", "id"+data[1][i][0])
                  label.innerHTML = data[1][i][0]
                  input.setAttribute("id", "id"+data[1][i][0])
                  input.setAttribute("type", "number")
                  input.setAttribute("value", "0")
                  input.setAttribute("min", "0")
                  input.setAttribute("class", "form-control changeValue")
                  input.setAttribute("aria-describedby", "basic-addon3")
                  document.querySelector('#setting').appendChild(div);
                  div.appendChild(label);
                  div.appendChild(input);
                }
              }
              updateGraph()
              document.querySelectorAll('.changeValue').forEach((item) => {
                item.addEventListener('change', (ev) => {
                  var actualSeg = document.querySelector('#selSeg').value
                  var valueChange = Number(ev.target.value)
                  var FAI = ev.target.labels[0].innerText
                  if (typeof cutConfig.seg[actualSeg-1] != "object"){
                    cutConfig.seg[actualSeg-1] = {}
                    cutConfig.seg[actualSeg-1][FAI] = 0
                  }
                  var zeg = cutConfig.seg[actualSeg-1][FAI] ?? 0
                  var ttFAI = getTotalValue(FAI)
                  if (valueChange < 0){
                    ev.target.value = cutConfig.seg[actualSeg-1][FAI]
                  }
                  if (((ttFAI - zeg) + valueChange) <= cutConfig.maxData[FAI]){
                    cutConfig.seg[actualSeg-1][FAI] = valueChange
                    updateGraph()
                  } else {
                    ev.target.value = valueChange - (((ttFAI-zeg)+valueChange) - cutConfig.maxData[FAI])
                    cutConfig.seg[actualSeg-1][FAI] = valueChange - (((ttFAI-zeg)+valueChange) - cutConfig.maxData[FAI])
                    updateGraph()
                  }
                });
              });
              mytable.data.datasets = update
              mytable.update();
              document.querySelector('#loaderfa').style.display = "none";
              document.querySelector('#settingBase').style.display = "block"
              document.querySelector('#sendButtonn').disabled = false
              endUcanSwoh = true
            }


              document.querySelector('#sendButtonn').addEventListener('click', ev => {
                var save = cutConfig
                document.querySelector('#loaderCuting').style.display = "block"
                for (var i = 0; i < document.getElementById('nbseg').value; i++) {
                  var myList = []
                  var reste = []
                  if (cutConfig.seg[i]) {
                    for (var s = 0; s < Object.keys(cutConfig.seg[i]).length; s++) {
                      var data = cutConfig.data[getIndexWithValue(cutConfig.data, Object.keys(cutConfig.seg[i])[s])][2]
                      myList = myList.concat(data.slice(0, cutConfig.seg[i][Object.keys(cutConfig.seg[i])[s]]))
                      cutConfig.data[getIndexWithValue(cutConfig.data, Object.keys(cutConfig.seg[i])[s])][2] = data.slice(cutConfig.seg[i][Object.keys(cutConfig.seg[i])[s]])
                    }
                  }
                  var result = myList.join('\n');
                  var blob = new Blob([result], {type: "text/plain;charset=utf-8"});
                  var date = new Date()
                  var reader = new FileReader();
                  var formData = new FormData(document.querySelector('#formFile'));
                  formData.set('path', 'decoupe');
                  formData.append("file", blob, `Segment_${Number(i)+1}_${date.getDate()}_${date.getMonth()+1}_${date.getFullYear()}_${date.getHours()}H${date.getMinutes()}min.txt`)
                  reader.readAsText(blob, "UTF-8");
                  reader.onload = function (evt){
                    if(result){
                      storeFile(formData, () => {
                          sendToServer(result.length, [result, [...formData][1][1]], '/liste/create', () => {})
                      });
                    }
                  }
                  saveAs(blob, 'Segment_'+(Number(i)+1)+'.txt');
                }
                for (var s = 0; s < cutConfig.data.length; s++) {
                  reste = cutConfig.data[s][2].concat(reste)
                }
                var result1 = reste.join('\n');
                var blob1 = new Blob([result1], {type: "text/plain;charset=utf-8"});
                var date1 = new Date()
                var reader1 = new FileReader();
                var formData1 = new FormData(document.querySelector('#formFile'));
                formData1.set('path', 'decoupe');
                formData1.append("file", blob1, `Reste_${date1.getDate()}_${date1.getMonth()+1}_${date1.getFullYear()}_${date1.getHours()}H${date1.getMinutes()}min.txt`)
                reader1.readAsText(blob1, "UTF-8");
                reader1.onload = function (evt){
                  if(result1){
                    storeFile(formData1, () => {
                        sendToServer(result1.length, [result1, [...formData1][1][1]], '/liste/create', () => {})
                    });
                  }
                }
                saveAs(blob1, 'Reste.txt');
                cutConfig = save
                document.querySelector('#loaderCuting').style.display = "none"
            });


            function getIndexWithValue(array, value){
              for (var i = 0; i < array.length; i++) {
                if (array[i][0] == value) {
                  return i
                }
              }
            }



            function updateGraph(){
              var qty = document.getElementById('nbseg').value
              var update = []
              var updatedatasets = []
              for (var i = 0; i < qty; i++) {
                update[i] = "Segement "+ (Number(i)+1)
              }
              for (var y = 0; y < cutConfig.data.length; y++) {
                var data = []
                data[qty] = cutConfig.data[y][1] - getTotalValue(cutConfig.data[y][0]);
                for (var i = 0; i < cutConfig.seg.length; i++) {
                  if (typeof cutConfig.seg[i] != "object"){
                    cutConfig.seg[i] = {}
                  }
                  data[i] = cutConfig.seg[i][cutConfig.data[y][0]] || 0
                }
                updatedatasets[y] = {
                  label: cutConfig.data[y][0],
                  backgroundColor: getRandomColor(y),
                  data: data
                }
              }
              update.push("Reste")
              mytable.data.datasets = updatedatasets
              mytable.data.labels = update
              mytable.update();
            }

          function getTotalValue(FAI) {
            var total = 0
            if (cutConfig.seg){
              for (var i = 0; i < cutConfig.seg.length; i++) {
                if(typeof cutConfig.seg[i] != "object"){
                  cutConfig.seg[i] = {}
                  cutConfig.seg[i][FAI] = 0
                }
                var tt = cutConfig.seg[i][FAI] || 0
                total = total + Number(tt)
              }
            }
            return Number(total);
          }


          var barChartData = {
    			labels: ['Segement 1', "Reste"],
          datasets: []
    		}
    			var ctx = document.getElementById('canvas').getContext('2d');
    			var mytable = new Chart(ctx, {
    				type: 'bar',
    				data: barChartData,
    				options: {
    					title: {
    						display: true,
    						text: 'Visuel du découpage de la liste'
    					},
    					tooltips: {
    						mode: 'index',
    						intersect: true
    					},
    					responsive: true,
    					scales: {
    						xAxes: [{
    							stacked: true,
    						}],
    						yAxes: [{
                  ticks: {

                    suggestedMin: 0
                  },
    							stacked: true
    						}]
    					}
    				}
    			});
    		};

    		//window.myBar.update();


