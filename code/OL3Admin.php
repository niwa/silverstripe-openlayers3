<?php

/**
 * File told conatain OL3Admin
 *
 * @author Catalyst SilverStripe Team <silverstripedev@catalyst.net.nz>
 * @package openlayers3
 */

/**
 * ModelAdmin pane to edit Ol3Maps and OL3Styles
 */

class OL3Admin extends ModelAdmin
{
    /**
     * Title for this admin in the main menu of the CMS
     * @var string
     */
    private static $menu_title = 'OpenLayers3';

    /**
     * URL segment for this admin
     * @var string
     */
    private static $url_segment = 'openlayers3';

    /**
     * Icon for this admin in the main menu of the CMS
     * @var string
     */
    private static $menu_icon = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAABxVBMVEUAAACKwMiEvMWOwsrc7e+Jv8jV6OqWx86Gvcav09eDvMUsTFQlRk5fd3wxUFcwUFdXcHbv8vQ6WF45V16isrQ/XGI0U1k3VVuNwsqGvsaFvcaFvcaFvcaAusSTxcyGvcaDvMWDvMWEvcWPwsqOwsqGvsaDvMWGvcaNwcmIv8eFvcaDvMWDvMWGvcaMwcmEvMWDvMV+usN/usSIvseDvMVytL5ytL+DvMWCvMVvsr5xtL+nzdKJv8d2tcCXxMvL0tG50tWvzdDHz85YcHWlsbGmsrJYcXUzUllCXmRCXmUxUFcuTVU5V106V14vTlY3VVw2VFtsgIRtgoU2VFs2VVw/XGMzUllacndbc3gzUlk+W2JHY2kxUFc+W2E/W2IxUFhGYmgzUVgzUlkwT1YwT1czUlk6WF6DvMWCu8SCvMSCvMWDvMSAusR9ucJ6uMJ5t8F6t8F8uMJ+ucN3tsBytL5ws75vsr1xs76Bu8R4t8Fvs75/usN1tcBusr1vsr6+1NaAusO91NWUoqPF1taKv8Zvs72JvsaWo6V/kZPH09OXxMuWxMqBkpXCzMyvz9KMv8euz9LDzcyyvLvU2ti0vbxXcHVYcHW6+De0AAAAZ3RSTlMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACNnx9NQEGY+HgYwYOhfSHDxuj+/ymHSu8wC8oycwpZ/z9b239/XBt/f1xZ/z9bijKzCorvb8uG6L7/KQcDoPz9IYPBWDf4WMGATR6ezUCoAEGQwAAAAlwSFlzAAAASAAAAEgARslrPgAAAPdJREFUGNNjYAACRglJKWkZWSYGKGCWk1dIT1dUUmYEc1kYVVTVMjLT09XUNVjZGBjYOTS1tDOy0oFAR1ePiZOBSd8gPTs9Iyc3L7+g0NCIi8HYJD09o6i4pLSsrKy03NSMwdwivaKyvKysqhQIqiytGKxtqmuA3CqwQJmtHYO9Q25tXV0dmF9b7OjE4OxS31BbVlcHVF9b3ejqxuDu0dTcUgs0orW2rbnd04uB29uno7OrtLa2tbuzx9ePh4GXzz8gsLevv3/CxKDgEH4BBgZBodCw8EmTJ0+JiIwSFgH7RjQ6JnbqtLj4BFGYd8USk5JTUtPEQWwAj4dLtLoJIMMAAAAldEVYdGRhdGU6Y3JlYXRlADIwMTYtMTItMDdUMjE6NDY6NDAtMDY6MDAS5WxbAAAAJXRFWHRkYXRlOm1vZGlmeQAyMDE2LTEyLTA3VDIxOjQ2OjQwLTA2OjAwY7jU5wAAAABJRU5ErkJggg==';

    /**
     * List of DataObject classes that are managed by this admin
     * @var string[]
     */
    private static $managed_models = [
        'OL3Map',
        'OL3StyleStyle',
    ];
}
