/**
 * Scrolling Table for PHPMaker 11
 * (C)2014 e.World Technology Ltd.
 */

function ew_ScrollableTable(elContainer, width, height) {
	var j = jQuery, $container = $("#" + elContainer), tbd = $container.find("table.ewTable")[0], ua = $.ua;
	var isSupportedMobile = function() { // customize supported mobile here
		return ua.chrome || ua.ipad || ua.iphone || ua.mobile == "windows" ||
			/OPR/.test(ua.userAgent); // note: Firefox returns mobile = null 
	}
	if (!ua.mobile && ua.ie && ua.ie < 8 || // note: requires IE >= 8
		ua.mobile && !isSupportedMobile() ||
		!width && !height || !tbd || !tbd.rows ||
		!$container[0] || !$container.is("div.ewGridMiddlePanel")) 
		return;		
	var timer, $subContainers = $(), $tbd = $(tbd), $window = $(window),
		$grid = $container.addClass("ewScrollableTable").closest(".ewGrid"),
		$panels = $grid.find(".ewGridLowerPanel, .ewGridUpperPanel");
	var isMobile = function() {
		return $.ua.mobile || $window.width() <= 767; // customize mobile width here, should match Bootstrap @screen-xs-max
	};		
	var getWidth = function() {
		return isMobile() ? "100%" : width;	
	};
	var setWidths = function() {
		var w = getWidth();
		$grid.css("width", w); // use width = 100% for mobile
		$panels.innerWidth(w);
		$subContainers.toggle(!w).width(w);
		try {					
			if ($panels.length) {
				w = $panels.innerWidth();
			} else { // no panel			
				var $div = $("<div></div>").appendTo($grid);
				w = $div.width(); 
				$div.remove();
			}
			$subContainers.width(w).filter(".ewScrollableTableBody").css("overflowX", (w) ? "auto" : "hidden");
		} finally {
			$subContainers.show();
		}	
	};
	$window.resize(function() {
		clearTimeout(timer);
    	timer = setTimeout(setWidths, 250);
	});
	$(function() {

		// height => Y scrolling => split the header
		var yscroll = height, elContainer = $container[0];		

		// insert DIV to all cells for getting/setting widths
		$(tbd.rows).each(function() {
			$(this.cells).each(function() {
				$(this).wrapInner("<div></div>");
			});
		});

		// get the widths
		var awidth = $(tbd.rows[0].cells).map(function() {
			return this.firstChild.offsetWidth;
		}).get();	

		// adjust the width/height of the container
		$container.width(width || "").height(height || "")
			.css("overflowX", (width) ? "auto" : "hidden").css("overflowY", (height) ? "auto" : "hidden");
		var xscrolling = width && elContainer.scrollWidth > elContainer.clientWidth;
		var yscrolling = height && elContainer.scrollHeight > elContainer.clientHeight;		

		// reset the container styles
		$container.width("").height("").css("overflowX", "hidden").css("overflowY", "hidden");

		// create container for header TABLE
		var tr, thd, $thd;
		if (yscroll) {
			var $hdContainer = $("<div></div>").width(width || "").addClass("ewScrollableTableHeader").appendTo($container);
			var $pthd = $("<table></table>").attr({ border: 0, cellSpacing: 0, cellPadding: 0, width: "100%" });
			tr = $pthd[0].insertRow(-1);
			$(tr).addClass("ewTableHeader");		
			$thd = $("<table></table>").attr({ border: 0, cellSpacing: 0, cellPadding: 0 })
				.addClass("ewTable ewTableSeparate").appendTo($(tr.insertCell(-1)).css({ padding: "0px", border: "0px" }));
			thd = $thd[0];
			$hdContainer.append($pthd);
			$subContainers = $subContainers.add($hdContainer);
		}

		// create container for body TABLE
		var $bdContainer = $("<div></div>").width(width || "").height(height || "")
			.css("overflowX", (width) ? "auto" : "hidden").css("overflowY", (height) ? "auto" : "hidden")
			.addClass("ewScrollableTableBody")
			.scroll(function(e) { if ($hdContainer) $hdContainer.scrollLeft(this.scrollLeft); });
		$container.append($bdContainer);
		$subContainers = $subContainers.add($bdContainer);

		// move the form to the body container
		$bdContainer.append(tbd);

		// move the table header
		if (yscroll) {
			$(tbd.tHead).clone().appendTo(thd);
			$(tbd.tHead).hide();
		}

		// sync the widths
		if (awidth && tbd.rows && tbd.rows[0] && tbd.rows[0].cells) {
			var stmt = "";
			for (var i = 0, ccnt = tbd.rows[0].cells.length; i < ccnt; i++) {
				if (thd && thd.tHead && thd.tHead.rows && thd.tHead.rows[0])
					stmt += "thd.tHead.rows[0].cells[" + i + "].firstChild.style.width='" + awidth[i] + "px';";
				for (var j = 0, rcnt = tbd.rows.length; j < rcnt; j++)
					stmt += "tbd.rows[" + j + "].cells[" + i + "].firstChild.style.width='" + awidth[i] + "px';";				
			}
			if (stmt != "") eval(stmt);
		}	

		// check if scrolling
		var bdContainer = $bdContainer[0];
		yscrolling = bdContainer.scrollHeight > bdContainer.clientHeight;
		xscrolling = bdContainer.scrollWidth > bdContainer.clientWidth;
		if (yscroll && yscrolling && tr)
			$(tr.insertCell(-1)).addClass("ewScrollableTableOverhang")
				.html($("<div></div>").width(bdContainer.offsetWidth - bdContainer.clientWidth));

		// setup the table
		ew_SetupTable(-1, tbd);	

		// check last row
		if (yscroll && tbd.rows && bdContainer.clientHeight > tbd.offsetHeight) {
			var $rows = $(tbd.rows).filter(":not(." + EW_ITEM_TEMPLATE_CLASSNAME + ")");
			var n = $rows.filter("[data-rowindex=1]").length || $rows.filter("[data-rowindex=0]").length || 1;
			$rows.filter(":gt(" + (-1 * n - 1) + ")").find("td." + EW_TABLE_LAST_ROW_CLASSNAME).removeClass(EW_TABLE_LAST_ROW_CLASSNAME).addClass(EW_TABLE_BORDER_BOTTOM_CLASSNAME);
		}
	});	
}
