<?php
/** @var $this MaritinaViewArchives */
defined( '_JEXEC' ) or die;// No direct access
JHtml::_( 'bootstrap.tooltip' );
JHtml::_( 'behavior.multiselect' );
JHtml::_( 'formbehavior.chosen', 'select' );
$user = JFactory::getUser();
$userId = $user->get( 'id' );

$listOrder = $this->escape( $this->state->get( 'list.ordering' ) );
$listDirn = $this->escape( $this->state->get( 'list.direction' ) );
$saveOrder = $listOrder == 'ordering';

if ( $saveOrder ) {
	$saveOrderingUrl = 'index.php?option=com_maritina&task=archives.saveOrderAjax&tmpl=component';
	JHtml::_( 'sortablelist.sortable', 'articleList', 'adminForm', strtolower( $listDirn ), $saveOrderingUrl );
}
$sortFields = $this->getSortFields();
?>
<script type="text/javascript">
	Joomla.orderTable = function () {
		var table = document.getElementById("sortTable");
		var direction = document.getElementById("directionTable");
		var order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>') {
			dirn = 'asc';
		} else {
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>

<form action="<?php echo JRoute::_( 'index.php?option=com_maritina&view=archives' ); ?>" method="post" name="adminForm" id="adminForm">
	<?php if (!empty( $this->sidebar )): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<?php else : ?>
		<div id="j-main-container">
			<?php endif; ?>

			<?php
			// Search tools bar
			echo JLayoutHelper::render( 'joomla.searchtools.default', array( 'view' => $this ) );
			?>

			<table class="table table-striped" id="articleList">
				<thead>
				<tr>
					<th width="1%" class="center hidden-phone" nowrap="nowrap">
						<?php echo JHtml::_( 'searchtools.sort', '', 'ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2' ); ?>
					</th>
					<th width="1%" class="hidden-phone">
						<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_( 'JGLOBAL_CHECK_ALL' ); ?>" onclick="Joomla.checkAll(this)" />
					</th>
					<th>
						<?php echo JHtml::_( 'searchtools.sort', 'JGLOBAL_TITLE', 'title', $listDirn, $listOrder ); ?>
					</th>
					<th width="10%" class="hidden-phone">
						<?php echo JHtml::_( 'searchtools.sort', 'JDATE', 'created', $listDirn, $listOrder ); ?>
					</th>
					<th width="1%" class="nowrap hidden-phone">
						<?php echo JHtml::_( 'searchtools.sort', 'JGRID_HEADING_ID', 'id', $listDirn, $listOrder ); ?>
					</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ( $this->items as $i => $item ) :
					$item->max_ordering = 0;
					$ordering = ( $listOrder == 'a.ordering' );
					$canEdit = $user->authorise( 'core.edit', '#__maritina_form.' . $item->id );
					$canCheckin = $user->authorise( 'core.manage', 'com_maritina' ) || $item->checked_out == $userId || $item->checked_out == 0;
					$canEditOwn = $user->authorise( 'core.edit.own', '#__maritina_form.' . $item->id ) && $item->created_by == $userId;
					$canChange = $user->authorise( 'core.edit.state', '#__maritina_form.' . $item->id ) && $canCheckin;
					?>
					<tr class="row<?php echo $i % 2; ?>">
						<td class="order nowrap center hidden-phone">
							<?php if ( $canChange ) :
								$disableClassName = '';
								$disabledLabel = '';
								if ( !$saveOrder ) :
									$disabledLabel = JText::_( 'JORDERINGDISABLED' );
									$disableClassName = 'inactive tip-top';
								endif; ?>
								<span class="sortable-handler <?php echo $disableClassName ?>" title="<?php echo $disabledLabel ?>" rel="tooltip"><i class="icon-menu"></i></span>
								<input type="text" style="display:none" name="order[]" size="5"
									value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
							<?php else : ?>
								<span class="sortable-handler inactive"><i class="icon-menu"></i></span>
							<?php endif; ?>
						</td>
						<td class="center hidden-phone">
							<?php echo JHtml::_( 'grid.id', $i, $item->id ); ?>
						</td>
						<td class="nowrap has-context">
							<div class="pull-left">
								<?php if ( $canEdit || $canEditOwn ) : ?>
									<a href="<?php echo JRoute::_( 'index.php?option=com_maritina&task=archive.edit&id=' . $item->id ); ?>" title="<?php echo JText::_( 'JACTION_EDIT' ); ?>">
										<?php echo $this->escape( $item->title ); ?></a>
								<?php else : ?>
									<span title="<?php echo JText::sprintf( 'JFIELD_ALIAS_LABEL', $this->escape( $item->alias ) ); ?>"><?php echo $this->escape( $item->title ); ?></span>
								<?php endif; ?>

							</div>
							<div class="pull-left">
								<?php
								// Create dropdown items
								JHtml::_( 'dropdown.edit', $item->id, 'Archive.' );
								JHtml::_( 'dropdown.divider' );
								if ( $item->state ) :
									JHtml::_( 'dropdown.unpublish', 'cb' . $i, 'Archives.' );
								else :
									JHtml::_( 'dropdown.publish', 'cb' . $i, 'Archives.' );
								endif;

								// render dropdown list
								echo JHtml::_( 'dropdown.render' );
								?>
							</div>

						</td>
						<td class="nowrap small hidden-phone">
							<?php echo JHtml::_( 'date', $item->created, 'd.m.Y H:i' ); ?>
						</td>
						<td class="center hidden-phone">
							<?php echo (int)$item->id; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php echo $this->pagination->getListFooter(); ?>

			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
			<?php echo JHtml::_( 'form.token' ); ?>

		</div>
</form>