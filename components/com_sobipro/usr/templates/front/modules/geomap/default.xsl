<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/SPGeoMod">
        <a>
            <xsl:attribute name="href">
                <xsl:value-of select="entry/url"/>
            </xsl:attribute>
            <xsl:value-of select="entry/name"/>
        </a>
    </xsl:template>
</xsl:stylesheet>
