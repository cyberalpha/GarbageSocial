<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl">	
	<xsl:template match="/EntriesModule">
		<ul>
			<xsl:for-each select="entries/entry">
				<li>
					<a>
						<xsl:attribute name="href">
							<xsl:value-of select="url" />
						</xsl:attribute>
						<xsl:value-of select="name" />
					</a>				
				</li>
			</xsl:for-each>
		</ul>
	</xsl:template>
</xsl:stylesheet>
