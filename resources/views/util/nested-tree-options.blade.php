@foreach ($listModels as $currentModel)
	<option {{ ($selected == $currentModel->getKey() ? 'selected="selected" ' : '' ) }} value="{{ $currentModel->getKey() }}">{{   $level.$currentModel->name }}</option>
	@if ($currentModel->treeChildren->count() > 0)
		@include('util.nested-tree-options', [ 'listModels'=>$currentModel->treeChildren, 'level'=>$level.$currentModel->name.', ', 'selected'=>$selected])	
	@endif
@endforeach