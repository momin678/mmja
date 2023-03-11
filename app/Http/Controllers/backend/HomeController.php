if ($id == "iteList") {
            $itme_lists = ItemList::orderBy('barcode', 'asc')
                ->where('barcode', 'like', "%{$request->q}%")
                ->orWhere('item_name', 'like', "%{$request->q}%")
                ->orWhere('unit', 'like', "%{$request->q}%")
                ->orWhere('sell_price', 'like', "%{$request->q}%")
                ->orWhere('vat_amount', 'like', "%{$request->q}%")
                ->latest()
                ->get();
            $i = 1;
            if ($request->ajax()) {
                return Response()->json(['page' => view('backend.ajax.itemList', ['itme_lists' => $itme_lists, 'i' => $i])->render()]);
            }
        }