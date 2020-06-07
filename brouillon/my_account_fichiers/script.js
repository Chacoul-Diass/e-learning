function sbidLocalStorageEnabled() {

try {
localStorage.setItem('_localStorageTest', '_localStorageValue');
return localStorage.getItem('_localStorageTest') === '_localStorageValue';

} catch (e) {
return false;
}
}


if (!window.sbidTracking || !window.sbidTracking.loadedScript) {

if (window.sbidTracking && window.sbidTracking.q) {
window.sbidTrackingTempQ = window.sbidTracking.q;
}

if (window.sbidTracking && window.sbidTracking.settings) {
window.sbidTrackingTempSettings = window.sbidTracking.settings;
}
else{
window.sbidTrackingTempSettings = {};
}

window.sbidTracking = {
itemTracked: 0,
cidName: 'cid',
acID: '57',
baseUrl: 'https://analytics.avatrade.io',
localStorageEnabled: sbidLocalStorageEnabled(),
settings: window.sbidTrackingTempSettings,
version:'0.67',
advancedTracking:true,
retargetingEnabled:true,
crossDomainEnabled:true,
events:[],
localMap:[],

setItem: function (key, value,ignoreSendMessage) {
try{

var exdays = 365;
this.localMap[key]=value;
if (this.localStorageEnabled) {
localStorage.setItem(key, value);
}
else {
var d = new Date();
d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
var expires = "expires=" + d.toUTCString();
document.cookie = key + "=" + value + ";" + expires + ";path=/";
}

if (this.crossDomainEnabled){
if (!ignoreSendMessage) {
this.iframeTrk.contentWindow.postMessage(
{
messageType:'setItem',
key:key,
value:value
},
'*');
}
}
}
catch(e){
console.warn('error setItem',e);
}
},
getItem: function (key) {
if (this.localMap[key]){
return this.localMap[key];
}
if (this.localStorageEnabled) {
return localStorage.getItem(key);
}
else {
var name = key + "=";
var ca = document.cookie.split(';');
for (var i = 0; i < ca.length; i++) {
var c = ca[i];
while (c.charAt(0) == ' ') {
c = c.substring(1);
}
if (c.indexOf(name) == 0) {
return c.substring(name.length, c.length);
}
}
return "";

}

},
trackUrlChange:function (){
var intIntervalTime = 100;

var fnCheckLocation = function(){
try {
if (this.lastTrackingUrl) {
if (this.lastTrackingUrl !== window.location.href) {
this.track();
}
}
}
catch(e){

}
};
setInterval( fnCheckLocation.bind(this), intIntervalTime );
},
fireRetargetingPixels: function (data) {

if (this.retargetingEnabled) {

if (this.getItem('sbTrackFiredTags') === 'disabled'){
return;
}

if (data.e === 'tag_fired'){
return;
}

if (!this.retargetingQueue) {
this.retargetingQueue = [];
}

this.retargetingQueue.push(data);

var tagsToFire = [];

if (this.retargetingEvents) {

var customerID = this.getItem('sbTrackCustomerID');
if (!customerID){
customerID = data.cu_id;
}

for (var currItemIndex in this.retargetingQueue) {

if (
this.retargetingQueue[currItemIndex].e == 'pv' &&
this.retargetingEvents.pv) {

for (var currPvEventIndex in this.retargetingEvents.pv) {

var currPvEvent = this.retargetingEvents.pv[currPvEventIndex];

if (window.location.href.indexOf(currPvEvent.url) > -1 && (!currPvEvent.has_cuid || customerID)) {

for (var tagIndex in currPvEvent.tags) {

var tagID = currPvEvent.tags[tagIndex];

tagsToFire.push(tagID);
}

}
}
}
else if (
(this.retargetingQueue[currItemIndex].e === 'click_in' ||
this.retargetingQueue[currItemIndex].e === 'click_out')
&& this.retargetingEvents.clicks) {

var clickText = '';
var clickDst = '';
var elementID = '';

if (this.retargetingQueue[currItemIndex].p){
for (var currParamIndex in this.retargetingQueue[currItemIndex].p){
if (this.retargetingQueue[currItemIndex].p[currParamIndex].click_text){
clickText = this.retargetingQueue[currItemIndex].p[currParamIndex].click_text;
}
if (this.retargetingQueue[currItemIndex].p[currParamIndex].click_dst){
clickDst = this.retargetingQueue[currItemIndex].p[currParamIndex].click_dst;
}
if (this.retargetingQueue[currItemIndex].p[currParamIndex].element_id){
elementID = this.retargetingQueue[currItemIndex].p[currParamIndex].element_id;
}
}
}

for (var currClickEventIndex in this.retargetingEvents.clicks) {

var currClickEvent = this.retargetingEvents.clicks[currClickEventIndex];

if (
(!currClickEvent.url || window.location.href.indexOf(currClickEvent.url) > -1) &&
(!currClickEvent.text || (clickText && clickText.indexOf(currClickEvent.text) > -1
)) &&
(!currClickEvent.e_id || (elementID === currClickEvent.e_id)) &&
(!currClickEvent.dst_url || (clickDst && clickDst.indexOf(currClickEvent.dst_url) > -1
)) &&
(!currClickEvent.has_cuid || customerID)
) {

for (var tagIndex in currClickEvent.tags) {

var tagID = currClickEvent.tags[tagIndex];

if (!this.retargetingEvents.custom[this.retargetingQueue[currItemIndex].e].has_cuid || customerID) {
tagsToFire.push(tagID);
}
}

}
}
}
else if (
this.retargetingQueue[currItemIndex].e !== 'pv' &&
this.retargetingQueue[currItemIndex].e !== 'click_in' &&
this.retargetingQueue[currItemIndex].e !== 'click_out' &&
this.retargetingEvents.custom &&
this.retargetingEvents.custom[this.retargetingQueue[currItemIndex].e]) {

if (!this.retargetingEvents.custom[this.retargetingQueue[currItemIndex].e].url ||
window.location.href.indexOf(this.retargetingEvents.custom[this.retargetingQueue[currItemIndex].e].url) > -1
) {

for (var tagIndex in this.retargetingEvents.custom[this.retargetingQueue[currItemIndex].e].tags) {

var tagID = this.retargetingEvents.custom[this.retargetingQueue[currItemIndex].e].tags[tagIndex];

tagsToFire.push(tagID);
}
}
}
}

var alreadyFiredTagsString = this.getItem('sbTrackFiredTags');
var firedTagsMap = {};
var shouldFireTag = false;
if (alreadyFiredTagsString){
var alreadyFiredTagsItems = alreadyFiredTagsString.split(",");
for (var currItem in alreadyFiredTagsItems){

if (alreadyFiredTagsItems[currItem].toString().length < 10) {
firedTagsMap[alreadyFiredTagsItems[currItem]] = alreadyFiredTagsItems[currItem];
}
}
}

var newTags = [];
for (var tagIndex in tagsToFire) {
var tagID = tagsToFire[tagIndex];

if (tagID.toString().length < 10) {
if (!firedTagsMap[tagID.toString()]) {
firedTagsMap[tagID.toString()] = tagID.toString();
newTags.push(tagID.toString());
shouldFireTag = true;

}
}
}

if (customerID && !this.getItem('sbTrackWCustomerID')){
shouldFireTag = true;

this.setItem('sbTrackWCustomerID','1');
}

if (shouldFireTag) {
var alreadyFiredTagsItems = [];
for (var currKey in firedTagsMap) {
alreadyFiredTagsItems.push(firedTagsMap[currKey]);
}

var joinedTags = alreadyFiredTagsItems.join(",");
this.setItem('sbTrackFiredTags', joinedTags);

var iframeUrl = this.baseUrl + "/pixel/trk_grp?tid=" + joinedTags + "&ac_id=" + this.acID + "&new_t=" + newTags.join(",");

var trackingTag = {
e:'tag_fired',
p: [
{new_tags:  newTags.join(",")},
{tags:joinedTags}
]
};

if (customerID){
iframeUrl = iframeUrl + "&cusid=" + customerID;
trackingTag.cu_id = customerID;
}

setTimeout(function () {

var iframe = window.document.createElement("iframe");

iframe.addEventListener("load", function() {
this.track(trackingTag);

}.bind(this));

iframe.setAttribute('src', iframeUrl);
iframe.width = 0;
iframe.height = 0;
iframe.style.display = "none";

if (document.body) {
document.body.appendChild(iframe);
}
else {
document.head.appendChild(iframe);
}


}.bind(this), 11000);

}

this.retargetingQueue = [];
}
}

},
getData: function(){
var data = {};

data.uid = this.getItem('sbTrackUID');

if (this.getItem('sbTrackArrivalID')) {
data.aid = this.getItem('sbTrackArrivalID');
}

if (this.getItem('sbTrackGKW')) {
data.keywords = this.getItem('sbTrackGKW');
}

if (this.getItem('sbTrackRef')) {
data.ref = this.getItem('sbTrackRef');
}

if (this.getItem('sbTrackArrivalPage')) {
data.landing_page = this.getItem('sbTrackArrivalPage');
}

try {
var sessionHistogram = this.getItem('sbTrackStartSessionsHistory');

if (sessionHistogram) {
sessionHistogram = sessionHistogram.split(',').map(Number)

var maxIndex = -1;
var maxValue = 0;

for (var currIndex in sessionHistogram) {
if (sessionHistogram[currIndex] > maxValue) {
maxValue = sessionHistogram[currIndex];
maxIndex = currIndex;
}
}

data.common_utc_day = Math.floor(maxIndex / 24) + 1;
data.common_utc_hour = maxIndex % 24;
}
}
catch (e){

}

if (this.getItem('sbTrackDataStore')) {

try{
var dataStore = JSON.parse(this.getItem('sbTrackDataStore'));

for (var currKeyName in dataStore){
data[currKeyName] = dataStore[currKeyName];
}
}
catch(e){
}
}

return data;
},
track: function (data) {
try {

if (!data) {
data = {e: 'pv'};
}

if (!data.e) {
data.e = 'pv';
}

if (!this.initialized){
if (!window.sbidTrackingTempQ){
window.sbidTrackingTempQ = [];
}
window.sbidTrackingTempQ.push(data);

return;
}

this.recalcSessionIfNeeded();

data.ts = new Date().getTime();

var previousTs = 0;

if (this.getItem('sbTrackLastTrackTime')){
previousTs = parseInt(this.getItem('sbTrackLastTrackTime'));
}
data.deltaTs = data.ts - previousTs;
this.setItem('sbTrackLastTrackTime', data.ts);

data.sessionID = this.getItem('sbTrackSession');

if (this.getItem('sbTrackNewSession') === '1'){
data.isNewSession = true;
this.setItem('sbTrackNewSession', '0');
}

data.sessionStartTime = this.getItem('sbTrackStartSessionTime');

if (data.e === 'pv') {
if (this.lastTrackingUrl === window.location.href) {
return;
}
this.lastTrackingUrl = window.location.href;
}

if (this.advancedTracking) {
this.events.push(data);
}
else {
this.send(data);
}

this.fireRetargetingPixels(data);
}
catch (e){

}
},
advTrack:function(data){

var eventData = {
event:data.e,
};

var customerID = '';
var prevCustomerID = this.getItem('sbTrackCustomerID');

if (data.cu_id) {
customerID = data.cu_id;
}
else {
customerID = this.getItem('sbTrackCustomerID');
}

try {

} catch (e) {}


if (customerID){
this.setItem('sbTrackCustomerID', customerID);
}

if (data.isNewSession) {
eventData.n_sess="1";
}

try {
eventData.del_ts = data.deltaTs.toString();
}
catch (err) {
eventData.del_ts = '0';
}

if (data.sessionStartTime){
eventData.sess_t = data.sessionStartTime.toString();
}

eventData.sess = data.sessionID;

if (this.getItem('sbTrackNewUser') === '1') {
eventData.n_uid="1";
}

if (this.getItem('sbTrackNewArrival') === '1') {
eventData.n_arr="1";
}

if (this.getItem('sbTrackReset') === '1') {
eventData.reset=this.getItem('sbTrackReset');
}

eventData.page = window.location.toString();

if (customerID) {
eventData.cu_id = customerID;

if (!prevCustomerID){
eventData.n_cu_id="1";
}
}

if (data.p) {
eventData.params = data.p;
}

if (data.gaid){
eventData.gaid = data.gaid;
}

if (data.idfa){
eventData.idfa=data.idfa;
}

if (data.ifa){
eventData.ifa=data.ifa;
}

if (data.apfid){
eventData.apfid=data.apfid;
}

if (data.clid){
this.setItem('sbTrackExternalClientID', data.clid);
}
else if (this.getItem('sbTrackExternalClientID')){
data.clid = this.getItem('sbTrackExternalClientID');
}

if (data.clid){
eventData.clid=data.clid;
}

this.setItem('sbTrackReset', '0');
this.setItem('sbTrackNewUser', '0');
this.setItem('sbTrackNewArrival', '0');

return eventData;
},
send: function (data) {
try {

var trackingItem = window.document.createElement("img");

var trackingUrl = this.baseUrl + "/track?ac_id=" + this.acID + '&rnd=' + this.itemTracked + '&event=' + data.e + '&ver=' + this.version;

var customerID = '';
var prevCustomerID = this.getItem('sbTrackCustomerID');

if (data.cu_id) {
customerID = data.cu_id;
}
else {
customerID = this.getItem('sbTrackCustomerID');
}

try {
if (!data.clid){
if (typeof (Storage) !== "undefined") {
var localAclID = localStorage.getItem("aclid");
if (localAclID){
data.clid = localAclID;
}
}
}
} catch (e) {}


if (customerID){
this.setItem('sbTrackCustomerID', customerID);

if (!prevCustomerID){
trackingUrl += "&n_cu_id=1";
}
}

if (data.isNewSession) {
trackingUrl += "&n_sess=1";
}

trackingUrl += "&del_ts=" + data.deltaTs.toString();

if (data.sessionStartTime){
trackingUrl += "&sess_t=" + data.sessionStartTime;
}

if (this.getItem('sbTrackNewUser') === '1') {
trackingUrl += "&n_uid=1";
}

if (this.getItem('sbTrackNewArrival') === '1') {
trackingUrl += "&n_arr=1";
}

if (this.getItem('sbTrackArrivalCID')) {
trackingUrl += "&arr_cid=" + this.getItem('sbTrackArrivalCID');
}

if (this.getItem('sbTrackPrevArrivals')) {
trackingUrl += "&p_arr=" + this.getItem('sbTrackPrevArrivals');
}

if (this.getItem('sbTrackGclid')) {
trackingUrl += "&pub_cid=" + this.getItem('sbTrackGclid');
}

if (this.getItem('sbTrackArrivalPage')) {
trackingUrl += "&a_page=" + encodeURIComponent(this.getItem('sbTrackArrivalPage'));
}

if (this.getItem('sbTrackReset') === '1') {
trackingUrl += "&reset=" + this.getItem('sbTrackReset');
}

trackingUrl += "&sess=" + data.sessionID;

trackingUrl += "&uid=" + this.getItem('sbTrackUID');


if (this.getItem('sbTrackArrivalID')) {
trackingUrl += "&aid=" + this.getItem('sbTrackArrivalID');
}

trackingUrl += '&page=' + encodeURIComponent(window.location.toString());

if (this.getItem('sbTrackRef') !== '') {
trackingUrl += "&ref=" + encodeURIComponent(this.getItem('sbTrackRef'));
}

if (customerID) {
trackingUrl += "&cu_id=" + customerID;
}

if (data.p) {
for (var paramIndex in data.p) {
for (var keyName in data.p[paramIndex]) {
trackingUrl += "&p_" + keyName + "=" + encodeURIComponent(data.p[paramIndex][keyName]);
}
}
}

if (data.gaid){
trackingUrl += "&gaid=" + data.gaid;
}

if (data.idfa){
trackingUrl += "&idfa=" + data.idfa;
}

if (data.ifa){
trackingUrl += "&ifa=" + data.ifa;
}

if (data.apfid){
trackingUrl += "&apfid=" + data.apfid;
}

if (data.clid){
this.setItem('sbTrackExternalClientID', data.clid);
}
else if (this.getItem('sbTrackExternalClientID')){
data.clid = this.getItem('sbTrackExternalClientID');
}

if (data.clid){
trackingUrl += "&clid=" + data.clid;
}


trackingItem.setAttribute('src', trackingUrl);
trackingItem.width = 0;
trackingItem.height = 0;
trackingItem.style.display = "none";

if (document.body){
document.body.appendChild(trackingItem);
}
else{
document.head.appendChild(trackingItem);
}

this.setItem('sbTrackReset', '0');
this.setItem('sbTrackNewUser', '0');
this.setItem('sbTrackNewArrival', '0');

this.itemTracked += 1;
}
catch (err) {
}
}
,
getSession: function () {
try{
var sbTrackArrivalID = this.getItem('sbTrackArrivalID');

if (!sbTrackArrivalID){
sbTrackArrivalID = this.getItem('sbTrackUID');
}

if (sbTrackArrivalID){
return sbTrackArrivalID;
}
else{
return '2';
}
}
catch (err) {
return '3';
}
},
addSessionHistory:function(){

try{

var currentDate = new Date();
var hour = currentDate.getUTCHours();
var dayOfWeek = currentDate.getUTCDay();

var sessionHistogram = this.getItem('sbTrackStartSessionsHistory');

if (sessionHistogram){
sessionHistogram = sessionHistogram.split(',').map(Number)
}
else{
sessionHistogram = [];
for (i = 0; i < (7 * 24); i++) {
sessionHistogram.push(0);
}
}

sessionHistogram[dayOfWeek * 24 + hour] += 1;

this.setItem('sbTrackStartSessionsHistory',sessionHistogram.join(','));

}
catch (e){
console.error(e);
}
},
recalcSessionIfNeeded: function () {
var lastSession = this.getItem('sbTrackStartSessionTime');

var generateNewSession = false;
if (!lastSession) {
generateNewSession = true;
}
else {
lastSession = parseInt(lastSession);

var diffMins = Math.round( ((new Date().getTime() - lastSession) / (1000 * 60) ));

if (diffMins > 30) {
generateNewSession = true;
}
}

if (generateNewSession) {

var session = this.generateID('s');

this.setItem('sbTrackSession', session);
this.setItem('sbTrackStartSessionTime', new Date().getTime());
this.setItem('sbTrackLastTrackTime', new Date().getTime());
this.setItem('sbTrackNewSession', '1');
this.setItem('sbTrackSessionLastUrl', window.location.toString());

this.addSessionHistory();
}

},
addZeroToNumber: function (val) {
if (val < 10) {
return '0' + val;
}
else {
return val + '';
}
},
generateID: function (initial) {
var d = new Date();

var dateString = this.addZeroToNumber(d.getFullYear()) +
this.addZeroToNumber((d.getMonth() + 1)) +
this.addZeroToNumber(d.getDate()) +
this.addZeroToNumber(d.getHours()) +
this.addZeroToNumber(d.getMinutes()) +
this.addZeroToNumber(d.getSeconds());

var rand = function () {
return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1)
};

return dateString + "_" + initial + "_" + rand() + rand() + rand();
}
,
getFromUrl: function (paramToFind) {
var paramMatchValue = '';

try{
if (window.location.search.indexOf("?") > -1) {

var params = window.location.search.split('?')[1].split('&');

for (var currParamIndex in params) {

if (params[currParamIndex].indexOf("=") > 0) {
var paramKey = params[currParamIndex].split('=')[0];
var paramValue = params[currParamIndex].split('=')[1];

if (paramKey === paramToFind) {

paramMatchValue = paramValue;
}
}
}
}
}
catch(e){
}
return paramMatchValue;
}
,
recalcUserIfNeeded: function (recalcArrival) {
var uid = this.getItem('sbTrackUID');
this.userID = uid;
var isNewArrivalByUrl = false;

var customerID = this.getItem('sbTrackCustomerID');
var cid = this.getFromUrl(this.cidName);
var gcamp = this.getFromUrl("g_camp");
var gkeyword = this.getFromUrl("g_kw");
var gclid = this.getFromUrl("gclid");
var encd = this.getFromUrl("enc_d");


if (cid) {
var prevCid = this.getItem('sbTrackArrivalCID');
if (prevCid !== cid) {
isNewArrivalByUrl = true;
}
}
else if (gcamp) {
var prevGcamp = this.getItem('sbTrackGcamp');

if (prevGcamp !== gcamp) {
isNewArrivalByUrl = true;
}
}
else if (encd) {
var prevEncd = this.getItem('sbTrackEncd');

if (prevEncd !== encd) {
isNewArrivalByUrl = true;
}
}
else if (gclid) {
var prevGclid = this.getItem('sbTrackGclid');

if (prevGclid !== gclid) {
isNewArrivalByUrl = true;
}
}
var tag = this.getFromUrl("tag");

if (!isNewArrivalByUrl && tag){

var prevTag = this.getItem('sbTrackTag');
if (prevTag !== tag) {
isNewArrivalByUrl = true;
}
}

if (tag){
this.setItem('sbTrackTag', tag);
}
if (isNewArrivalByUrl){
recalcArrival = true;
}

if (recalcArrival) {
this.setItem('sbTrackReset', '1');
}

if (!uid){

if (cid && cid.length > 10) {
uid = cid;
}
else {
uid = this.generateID('u');
}

this.setItem('sbTrackUID', uid);

this.userID = uid;
this.setItem('sbTrackNewUser', '1');

recalcArrival = true;
}

if (recalcArrival) {

var newArrivalID = '';

this.addArrivalToHistory();

if (cid && cid.length > 10) {
newArrivalID = cid;
}
else {
newArrivalID = this.generateID('r');
}

this.setItem('sbTrackArrivalID', newArrivalID);
this.arrivalID = newArrivalID;

this.setItem('sbTrackRef', document.referrer);

this.setItem('sbTrackArrivalCID', cid);

this.setItem('sbTrackGcamp', gcamp);

this.setItem('sbTrackGKW', gkeyword);

this.setItem('sbTrackEncd', encd);

this.setItem('sbTrackGclid', gclid);

this.setItem('sbTrackArrivalPage', window.location.toString());
this.setItem('sbTrackNewArrival', '1');
}

},
setInDataStore:function(key,value){

var dataStore = {};

try {
if (this.getItem('sbTrackDataStore')) {
dataStore = JSON.parse(this.getItem('sbTrackDataStore'));
}
}
catch(e) {

}

dataStore[key] = value;
this.setItem('sbTrackDataStore', JSON.stringify(dataStore));
},
getFromDataStore:function(key){

var dataStore = {};

try {
if (this.getItem('sbTrackDataStore')) {
dataStore = JSON.parse(this.getItem('sbTrackDataStore'));
}
}
catch(e) {

}

return dataStore[key];
},
addArrivalToHistory:function(){

try{
var currentArrivalID = this.getItem('sbTrackArrivalID');

if (currentArrivalID){
var prevArrivals = this.getItem('sbTrackPrevArrivals');

if (prevArrivals){
prevArrivals += '-';
}
else{
prevArrivals = '';
}

if (prevArrivals.length < 32 * 10 ){
prevArrivals += currentArrivalID;
this.setItem('sbTrackPrevArrivals',prevArrivals);
}
}
}
catch(e){
console.warn('warn prev arrivals');
}
},
advSend:function(){

if (!this.events || this.events.length === 0 ){
return
};

var eventsToSend = [];

for (var currEventIndex in this.events){
eventsToSend.push(this.advTrack(this.events[currEventIndex]));
}

var trackingObj = {
events:eventsToSend,
ac_id:this.acID,
ver:this.version
};

trackingObj.u_id = this.getItem('sbTrackUID');

if (this.getItem('sbTrackArrivalID')) {
trackingObj.a_id = this.getItem('sbTrackArrivalID');
}

if (this.getItem('sbTrackPrevArrivals')) {
trackingObj.p_arr = this.getItem('sbTrackPrevArrivals');
}

if (this.getItem('sbTrackRef') !== '') {
trackingObj.ref = this.getItem('sbTrackRef');
}

if (this.getItem('sbTrackArrivalPage')) {
trackingObj.a_page=this.getItem('sbTrackArrivalPage');
}

if (this.getItem('sbTrackArrivalCID')) {
trackingObj.arr_cid= this.getItem('sbTrackArrivalCID');
}

if (this.getItem('sbTrackGclid')) {
trackingObj.pub_cid=this.getItem('sbTrackGclid');
}

const jsonBody = JSON.stringify(trackingObj);

this.events = [];
fetch(this.baseUrl + "/track", {
method: 'POST',
headers: {
'Content-Type': 'application/json'
},
credentials: 'include',
body:jsonBody
})
.catch(function (error) {
});
},
initRetargeting:function(initCallback){
setTimeout(function(){

var initObj = {
ac_id:this.acID
};

const jsonBody = JSON.stringify(initObj);

fetch(this.baseUrl + "/track_re", {
method: 'POST',
headers: {
'Content-Type': 'application/json'
},
credentials: 'include',
body:jsonBody
})
.then(function (response) {
try {
if (response.status === 200) {
return response.json();
}
else{
return {};
}
}
catch(e) {
return {};
}
})
.then(function(data) {

this.retargetingEvents = data;
initCallback();

}.bind(this));

}.bind(this),200)
},

loadIframe:function() {

function gotMessageFromIframe(e) {
if (e.data && e.data.messageType === 'iframeTrkInit'){
this.init(e.data.initParams);
}

}

if (!this.crossDomainEnabled){
this.init();
return;
}

this.iframeTrk = window.document.createElement("iframe");

var iframeUrl = this.baseUrl + "/analytics/" + this.acID + "/iframe_track.html";

try{
var sbTrackElement = document.getElementById('sb_trk');
if (sbTrackElement){

iframeUrl = sbTrackElement.getAttribute('src').replace('script.js','iframe_track.html');
}
}
catch (e){

}

this.iframeTrk.setAttribute('src', iframeUrl);
this.iframeTrk.width = 0;
this.iframeTrk.height = 0;
this.iframeTrk.style.display = "none";

if (document.body) {
document.body.appendChild(this.iframeTrk);
}
else {
document.head.appendChild(this.iframeTrk);
}

if (window.addEventListener) {
window.addEventListener("message", gotMessageFromIframe.bind(this), false);
}
else {
window.attachEvent("onmessage", gotMessageFromIframe.bind(this));

}


setTimeout(function(){
this.init();

}.bind(this),10 * 1000)

},
init: function (initParams) {
try {

if (initParams){
var initParamsKeys = Object.keys(initParams);
for (var currKeyIndex in initParamsKeys){
var currKey = initParamsKeys[currKeyIndex];
var currValue = initParams[currKey];
this.setItem(currKey,currValue,true);
}
}

if (this.initialized){
return;
}

function secondStepInit(){

this.recalcUserIfNeeded(false);
this.recalcSessionIfNeeded();

this.initialized = true;
if (window.sbidTrackingTempQ) {
for (var queueIndex in window.sbidTrackingTempQ) {
var queueItem = window.sbidTrackingTempQ[queueIndex];
this.track(queueItem);
}
}

if ("createEvent" in document) {

var evt = document.createEvent("HTMLEvents");

evt.initEvent("tracking_loaded", false, true);
var element = document.getElementById('sb_trk');

if (element){
element.dispatchEvent(evt);
}

}
else {

var element = document.getElementById('sb_trk');

if (element){
element.fireEvent("tracking_loaded");
}
}

if (this.advancedTracking){

setInterval(this.advSend.bind(this), 10 * 1000);

var eventListener = window.attachEvent || window.addEventListener;
var onbeforeCloseEvent = window.attachEvent ? 'onbeforeunload' : 'beforeunload';

eventListener(onbeforeCloseEvent, function(e) {

for (var currEventIndex in this.events){
this.send(this.events[currEventIndex]);
}

}.bind(this));
}
}


if (this.initializing){
return;
}

this.initializing = true;

if (this.retargetingEnabled){
this.initRetargeting(secondStepInit.bind(this));
}
else{
secondStepInit.bind(this) ();
}

} catch (e) {
console.warn('error initialize',e);
}
}
};



window.sbidTracking.loadIframe();


window.document.addEventListener('click', function (event) {

try {

var trackingParam ={e:'click_in',p:[]};

if (event.target.innerText && event.target.innerText.length < 32){
var innerText = event.target.innerText;
innerText = innerText.replace(/[^a-zA-Z\s]/g, '');

if (innerText.length > 3) {
trackingParam.p.push({click_text: innerText});
}
}
if (event.target.href){

if (event.target.href.indexOf('javascript:') == -1){
trackingParam.p.push({click_dst: event.target.href});

if (event.target.hostname !== window.location.hostname){
trackingParam.e = 'click_out';
}
}
}
if (event.target.id){
trackingParam.p.push({element_id: event.target.id});
}

if (trackingParam.p.length > 0) {
window.sbidTracking.track(trackingParam);
}

}
catch (e) {

}
},
true
);

window.document.addEventListener("play", function() {window.sbidTracking.track({e:'video_start'}); }, true);
window.document.addEventListener("paused", function() {window.sbidTracking.track({e:'video_paused'}); }, true);
window.document.addEventListener("ended", function() {window.sbidTracking.track({e:'video_ended'}); }, true);

window.sbidTracking.loadedScript = true;
}