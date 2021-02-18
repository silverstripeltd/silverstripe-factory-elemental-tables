<?php

namespace Signify\Factory\Models;

use DNADesign\Elemental\Models\BaseElement;
use Signify\Factory\Models\TableItem;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\ORM\FieldType\DBField;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

class TableBlock extends BaseElement
{
    private static $table_name = 'TableBlock';

    private static $singular_name = 'Table block';

    private static $plural_name = 'Table blocks';

    private static $description = 'Table block';

    private static $icon = 'font-icon-block-table-data';

    private static $db = [
        'TableDescription' => 'HTMLText',
        'TableCaption' => 'Varchar',
        'NumberOfColumns' => 'Int',
        'FirstRowIsHeader' => 'Boolean',
        'LastRowIsFooter' => 'Boolean',
    ];

    private static $has_many = [
        'TableItems' => TableItem::class,
    ];

    private static $owns = [
        'TableItems',
    ];

    private static $defaults = [
        'NumberOfColumns'  => 4,
        'FirstRowIsHeader' => true,
        'LastRowIsFooter' => false,
    ];

    public static $intToWordMap = [
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
    ];

    /**
     * Returns a preview of the selected settings for display in the CMS.
     * @return string
     */
    public function getCMSPreview()
    {
        if ($numRows = $this->TableItems()->count()) {
            $plurality = $numRows == 1 ? '' : 's';
            return "$numRows row$plurality. $this->NumberOfColumns columns.";
        }

        return 'Not configured or populated yet';
    }

    /**
     * {@inheritDoc}
     */
    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        $blockSchema['content'] = $this->getCMSPreview();
        return $blockSchema;
    }

    /**
     * {@inheritDoc}
     */
    public function getType()
    {
        return 'Table';
    }

    /**
     * {@inheritDoc}
     */
    public function inlineEditable()
    {
        return false;
    }
}
