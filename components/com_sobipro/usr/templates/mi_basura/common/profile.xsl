<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl">
<xsl:output method="xml" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"/>
	<xsl:template name="UserContributions">
		<xsl:for-each select="/entry_details/entry/contributions/sections/*">
			<div>
				<div><xsl:value-of select="@name"/></div>
				<div class="spEntriesListContainer">
					<xsl:for-each select="entries/*">
						<div class="spEntriesListCell">
							<xsl:call-template name="ucVcard" />
						</div>
					</xsl:for-each>
				</div>
			</div>
			<div style="clear:both;"/>
		</xsl:for-each>
	</xsl:template>
	<xsl:template name="ucVcard">
		<span class="spEntriesListTitle">
			<a>
				<xsl:attribute name="href">
					<xsl:value-of select="url" />
				</xsl:attribute>
				<xsl:value-of select="name" />
			</a>
		</span>
		<xsl:for-each select="fields/*">			
			<xsl:if test="../../name != data">
				<div>
					<xsl:attribute name="class">
						<xsl:value-of select="@css_class" />
					</xsl:attribute>
	
					<xsl:if test="count(data/*) or string-length(data)">
						<xsl:if test="label/@show = 1">
							<strong><xsl:value-of select="label" />: </strong>
						</xsl:if>
					</xsl:if>
	
					<xsl:choose>
						<xsl:when test="count(data/*)">
							<xsl:copy-of select="data/*"/>  
						</xsl:when>
						<xsl:otherwise>
							<xsl:if test="string-length(data)">
								<xsl:value-of select="data" disable-output-escaping="yes" />
							</xsl:if>
						</xsl:otherwise>
					</xsl:choose>
	
					<xsl:if test="count(data/*) or string-length(data)">
						<xsl:if test="string-length(@suffix)">
							<xsl:text> </xsl:text>
							<xsl:value-of select="@suffix"/>
						</xsl:if>
					</xsl:if>
				</div>
			</xsl:if>
		</xsl:for-each>
	</xsl:template>
</xsl:stylesheet>